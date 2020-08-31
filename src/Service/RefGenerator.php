<?php
/**
 * Created by PhpStorm
 * User: marnel
 * Date: 31/08/2020
 * Time: 00:39
 */

namespace App\Service;

use App\Entity\Removal;
use App\Entity\Transfer;
use Doctrine\ORM\EntityManagerInterface;

class RefGenerator{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function generate(string $for = 'transfer'): string
    {
        if ($for === 'transfer') {
            $prefix = 'TR';
            $repo = $this->em->getRepository(Transfer::class);
        } else {
            $prefix = 'EN';
            $repo = $this->em->getRepository(Removal::class);
        }
        return $this->rand($prefix, $repo);
    }

    private function rand(string $prefix, $repo): string
    {
        $chaine = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $longueur = 10;
        $ref = $prefix;
        $max = mb_strlen($chaine, '8bit') - 1;
        for ($i = 0; $i < $longueur; ++$i) {
            $ref .= $chaine[random_int(0, $max)];
        }
        $old = $repo->findOneBy(['reference' => $ref]);
        if ($old !== null) {
            $this->rand($prefix, $repo);
        }
        return $ref;
    }

}