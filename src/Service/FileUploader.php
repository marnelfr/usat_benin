<?php
namespace App\Service;

use App\Entity\File;
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

    public function __construct($targetDirectory, Security $security, EntityManagerInterface $em)
    {
        $this->targetDirectory = $targetDirectory;
        $this->security = $security;
        $this->em = $em;
    }

    public function upload(UploadedFile $file, string $for = 'bol', bool $edit = false, $oldFileName = null)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = 'bol_' . date('Ymd') . '_' . uniqid();
        $newFilename = $safeFilename . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            if ($edit) {
                $fileSys = new Filesystem();
                if ($fileSys->exists($this->getTargetDirectory($for) . $oldFileName)) {
                    $fileSys->remove($this->getTargetDirectory($for) . $oldFileName);
                }
            }

            $file->move($this->getTargetDirectory($for) . date('Ymm') . '/', $newFilename);

            $saveFile = new File();
            $saveFile->setClientName($originalFilename)
                ->setLink(date('Ymm') . '/' . $newFilename)
                ->setSize(0) // TODO: Comment recuperer la taille d'un fichier uploader par l'utilisateur ?
                ->setUser($this->security->getUser())
            ;
            $this->em->persist($saveFile);
            $this->em->flush();

            return $saveFile->getLink();
        } catch (FileException $e) {
            dump($e->getMessage()); die();
            // ... handle exception if something happens during file upload
        }
    }

    public function getTargetDirectory($for)
    {
        // TODO: $for sera utiliser pour savoir quoi retouner quand on aura plusieurs repertoir
        return $this->targetDirectory;
    }
}
