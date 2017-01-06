<?php
namespace Jeckel\Scrum\Model;

use Codeception\Test\Unit;

/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 06/01/17
 * Time: 11:55
 */
class SprintTest extends Unit
{
    public function testSetGetNbDays()
    {
        $sprint = new Sprint();
        $this->assertSame($sprint, $sprint->setNbDays(10));
        $this->assertEquals(10, $sprint->getNbDays());
    }

    public function testSetGetPointsDone()
    {
        $sprint = new Sprint();
        $this->assertNull($sprint->getPointsDone());
        $this->assertSame($sprint, $sprint->setPointsDone(152));
        $this->assertEquals(152, $sprint->getPointsDone());
    }

    public function testSetGetStatus()
    {
        $sprint = new Sprint();
        $this->assertEquals(Sprint::STATUS_PLANNED, $sprint->getStatus());
        $this->assertSame($sprint, $sprint->setStatus(Sprint::STATUS_CURRENT));
        $this->assertEquals(Sprint::STATUS_CURRENT, $sprint->getStatus());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testSetInvalidStatus()
    {
        $sprint = new Sprint();
        $sprint->setStatus("foobar");
    }

    public function testStart()
    {
        $sprint = new Sprint();
        $this->assertSame($sprint, $sprint->start());
        $this->assertEquals(Sprint::STATUS_CURRENT, $sprint->getStatus());
    }

    /**
     * @expectedException \LogicException
     */
    public function testStartInvalidInitialStatus()
    {
        $sprint = new Sprint();
        $sprint->setStatus(Sprint::STATUS_COMPLETED);
        $sprint->start();
    }

    public function testComplete()
    {
        $sprint = new Sprint();
        $sprint->setStatus(Sprint::STATUS_CURRENT);
        $sprint->complete(120);
        $this->assertEquals(Sprint::STATUS_COMPLETED, $sprint->getStatus());
        $this->assertEquals(120, $sprint->getPointsDone());
    }

    /**
     * @expectedException \LogicException
     */
    public function testCompleteInvalidInitialStatus()
    {
        $sprint = new Sprint();
        $sprint->complete(210);
    }

    public function testGetCapacity()
    {
        $member_1 = $this->createMock(SprintMember::class);
        $member_1->expects($this->once())
            ->method('getCapacity')
            ->willReturn(7);

        $member_2 = $this->createMock(SprintMember::class);
        $member_2->expects($this->once())
            ->method('getCapacity')
            ->willReturn(9);

        $sprint = new Sprint();
        $sprint->addMember($member_1)->addMember($member_2);
        $sprint->setNbDays(10);

        $this->assertEquals(16, $sprint->getCapacity());
    }

    public function testGetEfficiency()
    {
        $sprint = new Sprint();
        $this->assertEquals(0, $sprint->getEfficiency());
        $sprint->setPointsDone(100);
        $this->assertEquals(0, $sprint->getEfficiency());

        $member = $this->createMock(SprintMember::class);
        $member->expects($this->once())
            ->method('getCapacity')
            ->willReturn(5);
        $sprint->addMember($member);
        $this->assertEquals(20, $sprint->getEfficiency());
    }
}
