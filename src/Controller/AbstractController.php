<?php

namespace App\Controller;

use App\Service\Log;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AbstractControl;
use Symfony\Component\Routing\Annotation\Route;

class AbstractController extends AbstractControl
{

    public static function getSubscribedServices()
    {
        $services = parent::getSubscribedServices();
        return array_merge($services, [
            'app.log' => '?'.Log::class
        ]);
    }

    public function denyAccessUnlessGranted($attributes, $subject = null, string $message = 'Access Denied.'): void
    {
        if (is_string($attributes)) {
            parent::denyAccessUnlessGranted($attributes, $subject, $message);
        }
        if (is_array($attributes)) {
            $granted = false;
            foreach ($attributes as $attribute) {
                if ($this->isGranted($attribute, $subject)) {
                    $granted = true;
                    break;
                }
            }
            if (!$granted) {
                throw $this->createAccessDeniedException($message);
            }
        }
    }

}
