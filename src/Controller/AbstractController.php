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

}
