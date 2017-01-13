<?php

/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 13/01/17
 * Time: 17:05
 */
class SprintEndPointCest
{
    public function testCalculateCapacity(\FunctionalTester $I)
    {
        $data = [
            'nb_days' => 10,
            'name' => 'Sprint #0'
        ];

        $response = $I->runApp('POST', '/sprint', $data);

        $I->assertEquals(200, $response->getStatusCode());
        $I->assertEquals("{\"sprint_id\":1}", (string) $response->getBody());

        $response_data = json_decode((string) $response->getBody());
        $I->seeInDatabase('sprint', [
            'sprint_id' => $response_data->sprint_id,
            'name'      => 'Sprint #0',
            'nb_days'   => 10
        ]);
    }
}
