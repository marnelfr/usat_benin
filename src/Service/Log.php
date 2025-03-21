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

    private $actions = [
        'index' => 'displayed.index',
        'new' => 'entity.creation',
        'show' => 'displayed.entity',
        'edit' => 'entity.edition',
        'try' => 'search.error',
        'treat' => 'entity.treatment',
        'final' => 'entity.finalized',
        'reject' => 'entity.rejected',
        'approve' => 'entity.approved',
        'delete' => 'entity.deleted'
    ];
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

    public function add(string $entity, string $action, $id = null, array $routeParams = [])
    {
//        try {
        $request = $this->stack->getCurrentRequest();
        $idIndex = array_search('id', $routeParams, true);
        if ($idIndex !== false) {
            unset($routeParams[$idIndex]);
            $routeParams['id'] = $id;
        }
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