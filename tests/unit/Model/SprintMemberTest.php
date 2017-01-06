<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 06/01/17
 * Time: 14:20
 */

namespace Jeckel\Scrum\Model;

use Codeception\Test\Unit;

class SprintMemberTest extends Unit
{
    public function testSetGetNbDaysPresence()
    {
        $member = new SprintMember();
        $this->assertSame($member, $member->setNbDaysPresence(10));
        $this->assertEquals(10, $member->getNbDaysPresence());
    }

    public function testSetGetAvailability()
    {
        $member = new SprintMember();
        $this->assertSame($member, $member->setAvailability(0.8));
        $this->assertEquals(0.8, $member->getAvailability());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetTooLowAvailability()
    {
        $member = new SprintMember();
        $member->setAvailability(-10);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetTooHighAvailability()
    {
        $member = new SprintMember();
        $member->setAvailability(1.5);
    }

    public function testGetCapacity()
    {
        $member = new SprintMember();
        $member->setNbDaysPresence(10)->setAvailability(0.8);
        $this->assertEquals(8, $member->getCapacity());
    }
}
