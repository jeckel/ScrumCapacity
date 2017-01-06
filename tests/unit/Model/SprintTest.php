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
}
