<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use App\Entity\User;
use App\Repository\ProfilRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly ProfilRepository $profilRepository,
    ){}

    public function load(ObjectManager $manager): void
    {
        $usersData = $this->getData();

        foreach ($usersData as $data) {
            $user = new User();

            $user->setUsername($data['username']);
            $user->setRoles($data['roles']);
            $user->setName($data['name']);
            $user->setLastName($data['last_name']);
            $user->setPhone($data['phone']);
            $user->setEmail($data['email']);
            $user->setAddress($data['address']);
            $user->setStatus(true);
            $user->setIsVerified(true);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setLastConnection(new \DateTimeImmutable());

            $profil = $this->profilRepository->findBy(['slug' => $data['profil']]);
            $hashedPassword = $this->hasher->hashPassword($user, 'password');

            $user->setProfil($profil[0]);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getData()
    {
        return [
            [
                'username' => 'admin',
                'roles' => ['ROLE_MANAGER'],
                'name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => '+2290100000000',
                'email' => 'info@marnel.me',
                'address' => 'Porto-Novo/Benin',
                'profil' => 'manager',
            ],
            [
                'username' => 'nel',
                'roles' => ['ROLE_STAFF_ADMIN'],
                'name' => 'Nel',
                'last_name' => 'GNAC',
                'phone' => '+2290100000000',
                'email' => 'info@marnel.me',
                'address' => 'Porto-Novo/Benin',
                'profil' => 'staff_admin',
            ],
            [
                'username' => 'grace',
                'roles' => ['ROLE_CONTROL'],
                'name' => 'Grâce',
                'last_name' => 'Gilli',
                'phone' => '+2290100000000',
                'email' => 'info@marnel.me',
                'address' => 'Porto-Novo/Benin',
                'profil' => 'controller',
            ],
            [
                'username' => 'bazil',
                'roles' => ['ROLE_STAFF'],
                'name' => 'Bazil',
                'last_name' => 'ATCHADÉ',
                'phone' => '+2290100000000',
                'email' => 'info@marnel.me',
                'address' => 'Porto-Novo/Benin',
                'profil' => 'staff',
            ],
            [
                'username' => 'serge',
                'roles' => ['ROLE_AGENT'],
                'name' => 'Serge',
                'last_name' => 'GOHOU',
                'phone' => '+2290100000000',
                'email' => 'info@marnel.me',
                'address' => 'Porto-Novo/Benin',
                'profil' => 'agent',
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            ProfilFixtures::class,
        ];
    }
}
