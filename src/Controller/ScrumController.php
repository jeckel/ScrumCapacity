<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 11/01/17
 * Time: 11:43
 */

namespace Jeckel\Scrum\Controller;

use Jeckel\Scrum\Model\Sprint;
use Jeckel\Scrum\Model\SprintMember;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;

class ScrumController
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

    public function postCalculate(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->container->logger->info("Slim-Skeleton '/sprint' route");

        $body = $request->getParsedBody();
        $sprint = new Sprint();
        foreach($body['sprint']['members'] as $member_data) {
            $member = new SprintMember();
            $member->setNbDaysPresence($member_data['nb_days_presence']);
            $member->setAvailability($member_data['availability']);
            $sprint->addMember($member);
        }

        return $response->withJson(['capacity' => $sprint->getCapacity()]);
    }
}
