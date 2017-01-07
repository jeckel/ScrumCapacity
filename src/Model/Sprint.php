<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 03/01/17
 * Time: 18:29
 */

namespace Jeckel\Scrum\Model;

/**
 * Class Sprint
 * @package Jeckel\Scrum\Model
 */
/**
 * Class Sprint
 * @package Jeckel\Scrum\Model
 */
class Sprint
{
    const STATUS_PLANNED = 'planned';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CURRENT = 'current';

    /**
     * @var int
     */
    protected $nb_days;

    /**
     * @var array
     */
    protected $members = [];

    /**
     * @var int
     */
    protected $points_done = null;

    /**
     * @var string
     */
    protected $status = self::STATUS_PLANNED;

    /**
     * @return int
     */
    public function getNbDays(): int
    {
        return $this->nb_days;
    }

    /**
     * @param int $nb_days
     * @return self
     */
    public function setNbDays(int $nb_days): self
    {
        $this->nb_days = $nb_days;
        return $this;
    }

    /**
     * @todo : check that we do not add same member twice
     * @param SprintMember $member
     * @return Sprint
     */
    public function addMember(SprintMember $member): self
    {
        $this->members[] = $member;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPointsDone()
    {
        return $this->points_done;
    }

    /**
     * @param int $points_done
     * @return self
     */
    public function setPointsDone(int $points_done): self
    {
        $this->points_done = $points_done;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        if (! in_array($status, [self::STATUS_PLANNED, self::STATUS_CURRENT, self::STATUS_COMPLETED])) {
            throw new \UnexpectedValueException("Invalid status $status provided");
        }
        $this->status = $status;
        return $this;
    }

    /**
     * @return Sprint
     */
    public function start(): self
    {
        if ($this->status != self::STATUS_PLANNED) {
            throw new \LogicException("Can not start a sprint which is not planned");
        }
        $this->status = self::STATUS_CURRENT;
        return $this;
    }

    /**
     * @param int $points_done
     * @return Sprint
     */
    public function complete(int $points_done): self
    {
        if ($this->status != self::STATUS_CURRENT) {
            throw new \LogicException("Can not stop a sprint which is not running");
        }
        $this->status = self::STATUS_COMPLETED;
        $this->points_done = $points_done;
        return $this;
    }

    /**
     * @return float
     */
    public function getCapacity(): float
    {
        $capacity = 0;
        /** @var SprintMember $member */
        foreach ($this->members as $member) {
            $capacity += $member->getCapacity();
        }
        return $capacity;
    }

    public function getEfficiency(): float
    {
        if (is_null($this->points_done)) {
            return 0;
        }
        $capacity = $this->getCapacity();
        if (0 == $capacity) {
            return 0;
        }
        return $this->points_done / $capacity;
    }
}
