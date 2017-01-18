<?php
/**
 * Created by PhpStorm.
 * User: jmercier
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

    /**
     * Sprint constructor.
     * @param Sprint $model
     */
    public function __construct(Sprint $model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
        return $this->model->toArray();
    }
}
