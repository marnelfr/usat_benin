<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserAuthenticator
{
    /**
     * @var UserRepository
     */
    private $repo;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, UserRepository $repo)
    {
        $this->repo = $repo;
        $this->tokenStorage = $tokenStorage;
    }

    public function auth(int $id, $request) {
        /** @var User $user*/
        $user = $this->repo->find($id);

        // Here, "public" is the name of the firewall in your security.yml
        $token = new UsernamePasswordToken($user, $user->getPassword(), "app_user_provider", $user->getRoles());

        // For older versions of Symfony, use security.context here
        $this->tokenStorage->setToken($token);

        // Fire the login event
        // Logging the user in above the way we do it doesn't do this automatically
        $event = new InteractiveLoginEvent($request, $token);
        $dispatcher = new EventDispatcher();
        $dispatcher->dispatch($event, "security.interactive_login");
    }

}
