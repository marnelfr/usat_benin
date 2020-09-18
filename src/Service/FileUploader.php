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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
    private $uploadsDirectory;

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

    private $localUploadsDirectory;

    public function __construct($targetDirectory, $localDirectory, Security $security, EntityManagerInterface $em, DemandeFileRepository $fileRepository)
    {
        $this->uploadsDirectory = $targetDirectory;
        $this->localUploadsDirectory = $localDirectory;
        $this->security = $security;
        $this->em = $em;
        $this->fileRepo = $fileRepository;
    }

    public function fileLink($entity, string $entity_name, string $fileUsage) {
        try{
            $demandeFile = $this->fileRepo->findOneBy([
                $entity_name => $entity,
                'usedFor' => $fileUsage
            ]);

            if (!$demandeFile) {
                return false;
            }

            $link = $demandeFile->getFile()->getLink();
            $absolutePath = $this->uploadsDirectory . $link;
            if (file_exists($absolutePath)) {
                goto END;
            }
            // TODO: trouver le moyen de supprimer les fichiers vieux
            /**
             * Ce qui serait cool serait d'arriver à pouvoir mettre en place un cron qui s'execute toutes les nuits à 00h
             * Et là, ça supprimer le dossier updloads carrement
             * Mais pour ça, il faudrait pouvoir être sur que la taille de tous les fichiers qu'ils
             * utiliserons dans une journée n'atteignera pas le disque dur alloué du serveur
             */

            $result = $this->client()->GetObject([
                'Bucket' => 'usat',
                'Key' => $link
            ]);
            $resource = $result->getBody()->getContentAsResource();
            $dirname = dirname($absolutePath);
            if (!is_dir($dirname)) {
                if (!mkdir($dirname, 0755, true) && !is_dir($dirname)) {
                    throw new \RuntimeException(sprintf('Impossible de créer le repertoire', $dirname));
                }
            }
            $fp = fopen($absolutePath, 'wb');
            stream_copy_to_stream($resource, $fp);

            END:
            return 'uploads/' . $link;
        }catch (\Exception $e) {
            return false;
        }
    }

    public function upload(UploadedFile $file, string $for = 'bol', $entity, $entity_name = 'removal', bool $edit = false, bool $local = false) {
        try{
            $extension = $file->guessExtension();

            $oldDemandeFile = null;
            if ($edit) {
                $oldDemandeFile = $this->fileRepo->findOneBy([
                    $entity_name => $entity,
                    'usedFor' => $for
                ]);
                if ($oldDemandeFile) {
                    $oldFilePath = $oldDemandeFile->getFile()->getLink();

                    $fileSys = new Filesystem();
                    if ($fileSys->exists($this->uploadsDirectory . $oldFilePath)) {
                        $fileSys->remove($this->uploadsDirectory . $oldFilePath);
                    }

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
            $this->fileRepo->$method($saveFile, $for, $entity, $entity_name);
            $this->em->flush();

            return true;
        }catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
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
                if ($fileSys->exists($this->uploadsDirectory . $oldFileName)) {
                    $fileSys->remove($this->uploadsDirectory . $oldFileName);
                }
            }

            $file->move($this->uploadsDirectory . date('Ymm') . '/' . $for . '/', $newFilename);

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

    public function showFile($entity, $entity_name, $usage, $view) {
        $fileLink = $this->fileLink($entity, $entity_name, $usage);

        return new JsonResponse([
            'view' => $view,
            'error' => $fileLink === false
        ]);
    }

    private function client() {
        if ($this->s3 === null) {
            $this->s3 = new S3Client($this->getConfig());
        }
        return $this->s3;
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
