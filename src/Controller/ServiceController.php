<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Repository\ShipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ServiceController
 * @package App\Controller
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/brand", name="service_brand")
     * @param BrandRepository  $repo
     * @param SluggerInterface $slugger
     */
    public function brand(BrandRepository $repo, SluggerInterface $slugger)
    {
        $list = 'Audi|Bmw|Citroen|Fiat|Ford|Mercedes|Opel|Peugeot|Renault|Volkswagen|Abarth|Aixam|Aleko|Alfa Romeo|Alpina|Alpine|Alpine-Renault|American-Motors|Aro|Artega|Aston Martin|Austin|Autobianchi|Auverland|Bedford|Bedford-GME|Bellier|Bentley|Bertone|Bluecar Groupe Bollore|Buic|Buick|Cadillac|Casalini|Caterham|Chatenet|Chevrolet|Chevrolet USA|Chrysler|Corvette|Cupra|Dacia|Daewoo|Daihatsu|Dallas|Dangel|Datsun|De La Chapelle|Dodge|Donkervoort|Dr|Ds|Due|Ferrari|Fisker|Ford USA|Fso|General motors|Gme|Grecav|Hommell|Honda|Hummer|Hyundai|Infiniti|Innocenti|Isuzu|Iveco|Jaguar|Jeep|Kia|Ktm|Lada|Lamborghini|Lancia|Land Rover|Lexus|Ligier|Little|Lotus|MPM|MVS|Mahindra|Maruti|Maserati|Mastretta|Maybach|Mazda|Mclaren|Mega|Mg|Mia|Microcar|Mini|Mini Hummer|Mitsubishi|Morgan|Moskvitch|Nissan|Oldsmobile|Pgo|Piaggio|Polski/fso|Pontiac|Porsche|Proton|Rolls-royce|Rover|Saab|Santana|Savel|Seat|Shuanghuan|Simpa JDM|Skoda|Smart|Ssangyong|Subaru|Suzuki|Talbot|Tavria|Tesla|Toyota|Triumph|Tvr|Umm|Venturi|Volvo|ZAZ|Zastava|Autres';
        $brands = explode('|', $list);
        foreach ($brands as $brand) {
            $repo->add(
                $brand,
                strtolower($slugger->slug($brand))
            );
        }
        dump('done...'); die();
    }


    /**
     * @Route("/ship", name="service_ship")
     * @param ShipRepository   $repo
     * @param SluggerInterface $slugger
     */
    public function ship(ShipRepository $repo, SluggerInterface $slugger)
    {
        $list = 'Ship 1|Ship 2|Ship 3';
        $ships = explode('|', $list);
        foreach ($ships as $ship) {
            $repo->add(
                $ship,
                strtolower($slugger->slug($ship))
            );
        }
        dump('done...'); die();
    }
}
