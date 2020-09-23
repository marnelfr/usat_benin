<?php
namespace App\Service;

use App\Entity\DemandeFile;
use App\Entity\File;
use App\Repository\DemandeFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File as Files;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;

class LocalFileUploader
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
     * @var DemandeFile
     */
    private $fileRepo;

    public function __construct($targetDirectory, Security $security, EntityManagerInterface $em, DemandeFileRepository $fileRepository)
    {
        $this->targetDirectory = $targetDirectory;
        $this->security = $security;
        $this->fileRepo = $fileRepository;
        $this->em = $em;
    }

    public function upload(UploadedFile $file, string $for = 'dp', $entity, $entity_name = 'removal', bool $edit = false)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $for . '_' . date('Ymd') . '_' . uniqid();
        $newFilename = $safeFilename . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
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
            AfterFileName:

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

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
