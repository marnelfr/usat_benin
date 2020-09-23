<?php

/**
 * Created by PhpStorm
 * User: gmlgi
 * Date: 14/08/2020
 * Time: 21:46
 */

namespace App\Twig;

use App\Repository\UserRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProfilePicture extends AbstractExtension
{

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dp', [$this, 'dp']),
        ];
    }

    public function dp(string $username)
    {
        $user = $this->repository->findOneBy(['username' => $username]);
        if ($user->getPicture() === false) {
            return 'img/user/default.jpg';
        }
        return 'local/' . $user->getPicture()->getFile()->getLink();
    }

}