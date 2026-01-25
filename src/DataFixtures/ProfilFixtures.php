<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profilesData = $this->getData();

        foreach ($profilesData as $data) {
            $profil = new Profil();
            $profil->setName($data['name']);
            $profil->setSlug($data['slug']);
            $profil->setPublic($data['public']);
            $profil->setDeleted(false);
            $profil->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($profil);
        }

        $manager->flush();
    }

    private function getData() {
        return [
            [
                'id' => 1,
                'name' => 'Commissionnaire agrée en Douane',
                'slug' => 'agent',
                'public' => true,
            ],
            [
                'id' => 2,
                'name' => 'Gestionnaire de parc',
                'slug' => 'manager',
                'public' => true,
            ],
            [
                'id' => 3,
                'name' => 'Personnel de USAT Bénin',
                'slug' => 'staff',
                'public' => false,
            ],
            [
                'id' => 4,
                'name' => 'Personnel du Ministère',
                'slug' => 'controller',
                'public' => false,
            ],
            [
                'id' => 5,
                'name' => 'Importateur',
                'slug' => 'importer',
                'public' => false,
            ],
            [
                'id' => 6,
                'name' => 'Responsable USAT Bénin',
                'slug' => 'staff_admin',
                'public' => false,
            ],
        ];
    }
}
