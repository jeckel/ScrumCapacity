<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 10/01/17
 * Time: 13:32
 */

namespace Jeckel\Scrum\Slim;

use Jeckel\Scrum\Controller\ScrumController;
use Jeckel\Scrum\Controller\SprintController;
use Jeckel\Scrum\Slim\Middleware\JsonResponse;
use Jeckel\Scrum\Slim\Renderer\JsonRenderer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Headers;
use Slim\Views\PhpRenderer;

/**
 * Class App
 * @package Jeckel\Scrum\Slim
 */
class App extends \Slim\App
{
    public function init(): App
    {
        return $this->initDependencies()->initRoutes();
    }

    protected function initDependencies(): App
    {
        $container = $this->getContainer();

        // view renderer
//        $container['renderer'] = function ($c) {
//            /** @var Container $c */
//            $settings = $c->get('settings')['renderer'];
//            return new PhpRenderer($settings['template_path']);
//        };

        $container['json_renderer'] = function ($c) {
            return new JsonRenderer();
        };

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
            $capsule = new \Illuminate\Database\Capsule\Manager;
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
                $this->get('', SprintController::class . ':getSprint');
                $this->put('', SprintController::class . ':putSprint');
                $this->delete('', SprintController::class . ':deleteSprint');
            }
        );
        $this->post('/sprint', SprintController::class . ':addSprint');


        $this->post('/scrum', ScrumController::class . ':postCalculate');


//        $this->get('/hello/[{name}]', function ($request, $response, $args) {
//            // Sample log message
//            $this->logger->info("Slim-Skeleton '/' route");
//
//            // Render index view
//            return $this->renderer->render($response, 'index.phtml', $args);
//        });

        return $this;
    }
}
