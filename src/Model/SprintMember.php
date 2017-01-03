<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 03/01/17
 * Time: 18:29
 */

namespace Jeckel\SC\Model;

/**
 * Class SprintMember
 * @package Jeckel\SC\Model
 */
class SprintMember
{
    /**
     * Nb days prensence in the sprint
     * @var int
     */
    protected $nb_days_presence = 0;

    /**
     * Ratio of availability (must be between 0 and 1)
     * 1 means member will be focus full time on the sprint (no meetings, no hotfix, nothing else)
     * 0 means member won't work at all on the sprint
     * @var float
     */
    protected $availability = 1;

    /**
     * @return int
     */
    public function getNbDaysPresence(): int
    {
        return $this->nb_days_presence;
    }

    /**
     * @param int $nb_days_presence
     * @return self
     */
    public function setNbDaysPresence(int $nb_days_presence): self
    {
        $this->nb_days_presence = $nb_days_presence;
        return $this;
    }

    /**
     * @return float
     */
    public function getAvailability(): float
    {
        return $this->availability;
    }

    /**
     * @param float $availability
     * @return self
     */
    public function setAvailability(float $availability): self
    {
        if ($availability < 0 || $availability > 1 ) {
            throw new \InvalidArgumentException("Availability must be between 0 and 1, $availability provided");
        }
        $this->availability = $availability;
        return $this;
    }

    /**
     * @return float
     */
    public function getCapacity(): float
    {
        return $this->availability * $this->nb_days_presence;
    }
}
