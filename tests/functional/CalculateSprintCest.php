<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 11/01/17
 * Time: 11:35
 */
class CalculateSprintCest
{
    public function testCalculateCapacity(FunctionalTester $I)
    {
        $data = [
            'sprint' => [
                'members' => [
                    [
                        'nb_days_presence' => 10,
                        'availability' => 1
                    ],
                    [
                        'nb_days_presence' => 8,
                        'availability' => 0.5
                    ]
                ]
            ]
        ];

        $response = $I->runApp('POST', '/scrum', $data);
        $I->assertEquals(200, $response->getStatusCode());
        $I->assertEquals("{\"capacity\":14}", (string) $response->getBody());
    }
}
