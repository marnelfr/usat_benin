<?php
/**
 * Created by PhpStorm
 * User: marnel
 * Date: 31/08/2020
 * Time: 00:39
 */

namespace App\Service;

use App\Entity\Logger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class Log
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var RequestStack
     */
    private $stack;

    private $actions = ['show', 'creation', 'edit', 'delete'];
    /**
     * @var RouterInterface
     */
    private $router;


    public function __construct(
        EntityManagerInterface $em,
        Security $security,
        RequestStack $stack,
        RouterInterface $router
    ) {
        $this->em = $em;
        $this->security = $security;
        $this->stack = $stack;
        $this->router = $router;
    }

    public function add(string $entity, int $action, $id = null, array $routeParams = [])
    {
//        try {
        $request = $this->stack->getCurrentRequest();
        $this->em->getRepository(Logger::class)->add(
            $entity,
            $id,
            $this->security->getUser(),
            $this->actions[$action],
            $this->router->generate(
                $request->get('_route'), $routeParams, UrlGeneratorInterface::ABSOLUTE_URL
            ),
            $request->getClientIp()
        );
//        } catch (\Exception $e) {
//            dd($e);
//        }
    }

}