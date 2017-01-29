<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 10/01/17
 * Time: 13:32
 */

namespace Jeckel\Scrum\Slim;

use Jeckel\Scrum\Controller\Factory\GetSprintFactory;
use Jeckel\Scrum\Controller\Factory\SprintControllerFactory;
use Jeckel\Scrum\Controller\GetSprint;
use Jeckel\Scrum\Controller\ScrumController;
use Jeckel\Scrum\Controller\SprintController;
use Jeckel\Scrum\Controller\SprintGroup;
use Jeckel\Scrum\Slim\Renderer\JsonRenderer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Container;

/**
 * Class App
 * @package Jeckel\Scrum\Slim
 */
class App extends \Slim\App
{
    public function init(): App
    {
        return $this->initDependencies()->registerFactories()->initRoutes();
    }

    protected function initDependencies(): App
    {
        $container = $this->getContainer();

        // monolog
        $container['logger'] = function ($c) {
            /** @var Container $c */
            $settings = $c->get('settings')['logger'];
            $logger = new Logger($settings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
            return $logger;
        };

        // Service factory for the ORM
        $container['db'] = function ($container) {
            $capsule = new \Illuminate\Database\Capsule\Manager();
            $capsule->addConnection($container['settings']['db']);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        };

        return $this;
    }

    protected function initRoutes(): App
    {
        $this->group(
            '/sprint/{id:[0-9]+}',
            function () {
                $this->get('', SprintController::class . ':getSprint')->setName('sprint');;
                $this->put('', SprintController::class . ':putSprint');
                $this->delete('', SprintController::class . ':deleteSprint');
            }
        );
        $this->post('/sprint', SprintController::class . ':addSprint');

        $this->post('/scrum', ScrumController::class . ':postCalculate');

        return $this;
    }

    protected function registerFactories(): App
    {
        $c = $this->getContainer();
        $c[SprintController::class] = function(Container $c) { return (new SprintControllerFactory())($c); };
        return $this;
    }
}
