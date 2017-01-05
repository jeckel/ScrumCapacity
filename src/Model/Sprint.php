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
class Sprint
{
    /**
     * @var int
     */
    protected $nb_days;

    /**
     * @var array
     */
    protected $members = [];

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
     * @param SprintMember $member
     * @return Sprint
     */
    public function addMember(SprintMember $member): self
    {
        $this->members[] = $member;
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
}
