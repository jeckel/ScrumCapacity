<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 18/01/17
 * Time: 08:53
 */

namespace Jeckel\Scrum\JsonEntity;

use Jeckel\Scrum\Model\Sprint;

/**
 * Class Sprint
 * @package Jeckel\Scrum\JsonEntity
 */
class SprintEntity extends AbstractEntity
{
    /**
     * @var Sprint
     */
    protected $model;

    protected $links;

    /**
     * Sprint constructor.
     * @param Sprint $model
     */
    public function __construct(Sprint $model)
    {
        $this->model = $model;
    }

    public function addLink(string $key, string $link): SprintEntity
    {
        $this->links[$key] = $link;
        return $this;
    }

    protected function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
        $data = $this->model->toArray();
        unset($data['deleted_at']);
        return $data;
    }
}
