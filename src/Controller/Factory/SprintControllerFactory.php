<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 18/01/17
 * Time: 13:55
 */

namespace Jeckel\Scrum\Controller\Factory;

use Jeckel\Scrum\Common\FactoryInterface;
use Jeckel\Scrum\Controller\SprintController;
use Slim\Container;

/**
 * Class SprintControllerFactory
 * @package Jeckel\Scrum\Controller\Factory
 */
class SprintControllerFactory implements FactoryInterface
{
    /**
     * @param Container $c
     * @return SprintController
     */
    public function __invoke(Container $c)
    {
        // initialize DB
        $c->get('db');

        $controller = new SprintController($c);
        $controller->setRouter($c->router)
            ->setLogger($c->logger);
        return $controller;
    }
}
