<?php
namespace App\Service;

use App\Entity\File;
use App\Repository\DemandeFileRepository;
use AsyncAws\Core\Configuration;
use AsyncAws\S3\S3Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File as Files;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
    private $targetDirectory;
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Configuration
     */
    private $config;

    private $s3;
    /**
     * @var DemandeFile
     */
    private $fileRepo;

    public function __construct($targetDirectory, Security $security, EntityManagerInterface $em, DemandeFileRepository $fileRepository)
    {
        $this->targetDirectory = $targetDirectory;
        $this->security = $security;
        $this->em = $em;
        $this->fileRepo = $fileRepository;
    }

    public function upload(UploadedFile $file, string $for = 'bol', $entity, $entity_name = 'removal', bool $edit = false) {
//        try{
            $extension = $file->guessExtension();

            $oldDemandeFile = null;
            if ($edit) {
                $oldDemandeFile = $this->fileRepo->findOneBy([
                    $entity_name => $entity,
                    'usedFor' => $for
                ]);
                if ($oldDemandeFile) {
                    $oldFilePath = $oldDemandeFile->getFile()->getLink();
                    $parts = explode('.', $oldFilePath);
                    if (end($parts) === $extension) {
                        $filePath = $oldFilePath;
                        goto AfterFileName;
                    }
                }
            }

            $safeFilename = $for . '_' . date('Ymd') . '_' . uniqid();
            $filePath = $for . '/' . date('Ymm') . '/' . $safeFilename . '.' . $extension;

            AfterFileName:
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $resource = \fopen(
                $file->getRealPath(),'r'
            );
            $this->client()->PutObject([
                'Bucket' => 'usat',
                'Key' => $filePath,
                'Body' => $resource,
            ]);

            if ($edit && $oldDemandeFile) {
                $saveFile = $this->fillFile($oldDemandeFile->getFile(), $originalFilename, $filePath);
            } else {
                $saveFile = $this->fillFile(new File(), $originalFilename, $filePath);
            }

            $method = $edit ? 'edit' : 'add';
//            $this->em->persist($entity);
            $this->fileRepo->$method($saveFile, $for, $entity, $entity_name);
            $this->em->flush();

            return true;
//        }catch (\Exception $e) {
//            dd($e->getMessage());
//            return false;
//        }
    }

    private function fillFile(File $file, $originalFilename, $filePath) {
        $file->setClientName($originalFilename)
            ->setLink($filePath)
            ->setSize(0) // TODO: Comment recuperer la taille d'un fichier uploader par l'utilisateur ?
            ->setUser($this->security->getUser())
        ;
        $this->em->persist($file);
        return $file;
    }



    public function uploadBack(UploadedFile $file, string $for = 'bol', bool $edit = false, $oldFileName = null)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $for . '_' . date('Ymd') . '_' . uniqid();
        $newFilename = $safeFilename . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            if ($edit) {
                $fileSys = new Filesystem();
                if ($fileSys->exists($this->targetDirectory . $oldFileName)) {
                    $fileSys->remove($this->targetDirectory . $oldFileName);
                }
            }

            $file->move($this->targetDirectory . date('Ymm') . '/' . $for . '/', $newFilename);

            $saveFile = new File();
            $saveFile->setClientName($originalFilename)
                ->setLink(date('Ymm') . '/' . $for . '/' . $newFilename)
                ->setSize(0) // TODO: Comment recuperer la taille d'un fichier uploader par l'utilisateur ?
                ->setUser($this->security->getUser())
            ;
            $this->em->persist($saveFile);
            $this->em->flush();

            return $saveFile;
        } catch (FileException $e) {
            dump($e->getMessage()); die();
            // ... handle exception if something happens during file upload
        }
    }

    private function client() {
        if ($this->s3 === null) {
            $this->s3 = new S3Client($this->getConfig());
        }
        return $this->s3;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    private function getConfig(): Configuration {
        if ($this->config === null) {
            $this->config = Configuration::create([
                'region' => 'eu-west-3',
                'accessKeyId' => 'AKIA2BY4C36SVCOVM57H',
                'accessKeySecret' => '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',
                'endpoint' => 'https://s3.eu-west-3.amazonaws.com'
            ]);
        }
        return $this->config;
    }
}
