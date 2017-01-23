<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 13/01/17
 * Time: 16:58
 */

namespace Jeckel\Scrum\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jeckel\JsonApiResponse\SingleDocument;
use Jeckel\Scrum\Common\RouterAwareInterface;
use Jeckel\Scrum\Common\RouterAwareTrait;
use Jeckel\Scrum\Model\Sprint;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class SprintController
 * @package Jeckel\Scrum\Controller
 */
class SprintController implements LoggerAwareInterface, RouterAwareInterface
{
    use LoggerAwareTrait;
    use RouterAwareTrait;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return ResponseInterface
     */
    public function addSprint(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->logger->info(__METHOD__);

        $body = $request->getParsedBody();

        $sprint = new Sprint();
        $sprint->setNbDays($body['nb_days']);
        $sprint->setName($body['name']);
        $sprint->save();

        return $response->withJson($this->getSingleSprintResponse($sprint)->jsonSerialize());
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return ResponseInterface
     */
    public function getSprint(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->logger->info(__METHOD__);

        try {
            /** @var Sprint $sprint */
            $sprint = Sprint::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => '404 Not found'], 404);
        }

        return $response->withJson($this->getSingleSprintResponse($sprint)->jsonSerialize());
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return mixed
     */
    public function putSprint(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info(__METHOD__);

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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return mixed
     */
    public function deleteSprint(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info(__METHOD__);

        try {
            /** @var Sprint $sprint */
            $sprint = Sprint::findOrFail($args['id']);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => '404 Not found'], 404);
        }

        $sprint->delete();
        return $response->withJson([]);
    }

    protected function getSingleSprintResponse(Sprint $sprint)
    {
        return new SingleDocument([
            'data' => [
                'id' => $sprint->getJsonId(),
                'type' => $sprint->getJsonType(),
                'attributes' => $sprint->getJsonAttributes()
            ],
            'links' => [
                'self' => $this->router->pathFor('sprint', ['id' => $sprint->getId()])
            ]
        ]);
    }
}
