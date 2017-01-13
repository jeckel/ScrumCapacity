<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 13/01/17
 * Time: 16:58
 */

namespace Jeckel\Scrum\Controller;

use Jeckel\Scrum\Model\Sprint;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \Slim\Container;

class SprintController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * ScrumController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function addSprint(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->container->logger->info(__METHOD__);

        $body = $request->getParsedBody();

        $table = $this->container->get('db')->table('sptint');

        $sprint = new Sprint();
        $sprint->setNbDays($body['nb_days']);
        $sprint->setName($body['name']);
        $sprint->save();

//        $table = $c->get('db')->table('sptint');
//        $body = $request->getParsedBody();

        return $response->withJson(['sprint_id' => 1]);
    }
}
