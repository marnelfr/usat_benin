<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\FleetRepository;
use App\Repository\ShipRepository;
use App\Repository\UserRepository;
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
     * @Route("/fleet", name="service_fleet")
     * @param FleetRepository $repo
     * @param UserRepository  $userRepo
     */
    public function fleet(FleetRepository $repo, UserRepository $userRepo)
    {
        $list = 'TAGA,B,D|SOBAMAR|ROYAL|LAMA|STEPHANIE|AL-WOUDJOUD|TAUA,B|BALLA(Ekpè)|FADI-STAR|RANDA|RITIS1,2,3|AT-SALAM|ASCOMAR|YASMINE|JANA1|RACHA|FRANITA|COUBAICI|SOGIC|TRADEPARC|TREEKING|DomianeFIFA|DomaineGTS|ALMADINA|BAHSOUN|MIGINTERNATIONAL|SHARDI-CAR|NAS-WEBE|STARFIVE|HADICAR|BALLA|HOVAS+ANNEXE|GENERALCONTRACTOR|MICHA|MICHAANNEXE|CONSULTIVE|O-GParc|SEATRAC|ZF|ENI-TRANS|SOBENI|SODECY|DAS|DASAM|ATLANTIQUEPARC|CONTRACTOR|RANDA(SEKANDJI)|DOMTRACO|ROSEPARC';
        $fleets = explode('|', $list);
        $user = $userRepo->find(1);
        foreach ($fleets as $fleet) {
            $repo->add(
                $fleet,
                'Description du parc ' . $fleet . ' à mettre à jour',
                $user
            );
        }
        $this->getDoctrine()->getManager()->flush();
        dump('done...'); die();
    }

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
        $list = 'ARGO|BSL CAPE TOWN|CPO NORFOLK|GRANDE ATLANTICO|GRANDE BENIN|GRANDE DAKAR|GRANDE TEMA|GRANDE TOGO|JPO SCORPIUS|LPG LAPEROUSE|MAERSK CAPE COAST|MERKUR FJORD|MSC DONATA|MSC INDIA|MSC KATYAYNI|MSC SANDRA|MSC SANDRA|MSC SHAULA|NESTOS REEFER|NORDIC MACAU|NORTHERN PRELUDE|PORT GDYNIA|SFL TRENT|SILVER MOON|SURVILLE|THERESE SELMER|TOMMI RITSCHER';
        $ships = explode('|', $list);
        foreach ($ships as $ship) {
            $repo->add(
                $ship,
                $slugger->slug($ship)->lower()
            );
        }
        dump('done...'); die();
    }
}
