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
}
