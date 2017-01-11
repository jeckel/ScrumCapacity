<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 08/01/17
 * Time: 00:07
 */

namespace Jeckel\Scrum\Model;

/**
 * Class Project
 * @package Jeckel\Scrum\Model
 */
class Project
{
    /**
     * @var array
     */
    protected $sprints = [];

    /**
     * @var int
     */
    protected $current_sprint = 0;

    /**
     * @param Sprint $sprint
     * @return Project
     * @throws \Exception
     */
    public function addSprint(Sprint $sprint): self
    {
        $id = $sprint->getId();
        if (isset($this->sprints[$id])) {
            throw new \Exception("There is already a sprint registered with id {$id}");
        }
        $this->sprints[$id] = $sprint;
        return $this;
    }

    /**
     * @param $sprint
     * @return Project
     */
    public function setCurrentSprint($sprint): self
    {
        if ($sprint instanceof Sprint) {
            $sprint = $sprint->getId();
        }
        if (! is_int($sprint)) {
            throw new \InvalidArgumentException("Sprint id must be an int");
        }
        $this->current_sprint = $sprint;
    }

    /**
     * @return Sprint
     */
    public function getCurrentSprint(): Sprint
    {
        return $this->sprints[$this->current_sprint];
    }
}