<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 10/01/17
 * Time: 13:32
 */

namespace Jeckel\Scrum\Slim;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\Container;
use Slim\Views\PhpRenderer;

class App extends \Slim\App
{
    public function init(): App
    {
        $container = $this->getContainer();

        // view renderer
        $container['renderer'] = function ($c) {
            /** @var Container $c */
            $settings = $c->get('settings')['renderer'];
            return new PhpRenderer($settings['template_path']);
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


        // routes
        $this->get('/[{name}]', function ($request, $response, $args) {
            // Sample log message
            $this->logger->info("Slim-Skeleton '/' route");

            // Render index view
            return $this->renderer->render($response, 'index.phtml', $args);
        });

        return $this;
    }
}
