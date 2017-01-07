<?php

use Jeckel\Scrum\Model\Sprint;
use Jeckel\Scrum\Model\SprintMember;

class StartAndStopSprintCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $sprint = new Sprint();
        $memberFoo = new SprintMember();
        $memberBar = new SprintMember();

        $sprint->addMember($memberFoo)->addMember($memberBar);

        $memberBar->setAvailability(0.8)->setNbDaysPresence(10);
        $memberFoo->setAvailability(0.7)->setNbDaysPresence(7);
        $sprint->setNbDays(10);

        // 0.8 * 10 + 0.7 * 7 = 12.9
        $I->assertEquals(12.9, $sprint->getCapacity());

        $sprint->start();
        $sprint->complete(11);

        $I->assertEquals(11, $sprint->getPointsDone());
        $I->assertEquals(Sprint::STATUS_COMPLETED, $sprint->getStatus());
        $I->assertEquals(0.85, round($sprint->getEfficiency(), 2));
    }
}
