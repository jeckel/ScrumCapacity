<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 13/01/17
 * Time: 16:58
 */

namespace Jeckel\Scrum\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        // @todo is it required to affect the full container, and not only what's needed ?
        $this->container = $container;
        // @todo : find a way to initialze DB elsewhere
        $this->container->get('db');
    }

    public function addSprint(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->container->logger->info(__METHOD__);

        $body = $request->getParsedBody();

        $sprint = new Sprint();
        $sprint->setNbDays($body['nb_days']);
        $sprint->setName($body['name']);
        $sprint->save();

        return $response->withJson(['sprint_id' => 1]);
    }

    public function getSprint(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->container->logger->info(__METHOD__);

        try {
            /** @var Sprint $sprint */
            $sprint = Sprint::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => '404 Not found'], 404);
        }
        return $response->withJson($sprint->toArray());
    }

    public function putSprint(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->container->logger->info(__METHOD__);

        $body = $request->getParsedBody();
        try {
            /** @var Sprint $sprint */
            $sprint = Sprint::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => '404 Not found'], 404);
        }

        if (isset($body['nb_days'])) {
            $sprint->setNbDays($body['nb_days']);
        }
        if (isset($body['name'])) {
            $sprint->setName($body['name']);
        }
        $sprint->save();
        return $response->withJson($sprint->toArray());
    }

    public function deleteSprint(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->container->logger->info(__METHOD__);

        try {
            /** @var Sprint $sprint */
            $sprint = Sprint::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => '404 Not found'], 404);
        }

        $sprint->delete();
        return $response->withJson([]);
    }
}
