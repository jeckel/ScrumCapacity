<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 13/01/17
 * Time: 17:05
 */
class SprintEndPointCest
{
    public function testPostSprint(\FunctionalTester $I)
    {
        $data = [
            'nb_days' => 10,
            'name' => 'Sprint #0'
        ];

        $response = $I->runApp('POST', '/sprint', $data);

        $I->assertNotEquals(200, $response->getStatusCode());

        $response_data = json_decode((string) $response->getBody());
        $I->seeInDatabase('sprint', [
            'sprint_id' => $response_data->data->id,
            'name'      => 'Sprint #0',
            'nb_days'   => 10
        ]);

        $expected = json_decode(file_get_contents(__DIR__ . '/Fixtures/Sprint1.json'));
        $expected->data->attributes->created_at = $I->grabFromDatabase('sprint', 'created_at', array('sprint_id' => $response_data->data->id));
        $expected->data->attributes->updated_at = $I->grabFromDatabase('sprint', 'updated_at', array('sprint_id' => $response_data->data->id));
        $I->assertJsonAreEquals(json_encode($expected), (string) $response->getBody());
    }

    public function testGetSprint(\FunctionalTester $I)
    {
        $data = [
            'name' => 'Sprint #256',
            'sprint_id' => 256,
            'nb_days' => 8,
            'created_at' => '2017-01-14 20:00:00',
            'updated_at' => '2017-01-14 23:00:00',
            'deleted_at' => null
        ];
        $I->haveInDatabase('sprint', $data);

        $response = $I->runApp('GET', '/sprint/256');
        $I->assertEquals(200, $response->getStatusCode());

        $expected = file_get_contents(__DIR__ . '/Fixtures/Sprint256.json');

        $I->assertJsonAreEquals($expected, (string) $response->getBody());
    }

    public function testGetNotFoundSprint(\FunctionalTester $I)
    {
        $response = $I->runApp('GET', '/sprint/123');
        $I->assertEquals(404, $response->getStatusCode());
        $I->assertEquals("{\"error\":\"404 Not found\"}", (string) $response->getBody());
    }

    public function testPutSprint(\FunctionalTester $I)
    {
        $data = [
            'name' => 'Sprint #256',
            'sprint_id' => 256,
            'nb_days' => 8,
            'created_at' => '2017-01-14 20:00:00',
            'updated_at' => '2017-01-14 23:00:00'
        ];
        $I->haveInDatabase('sprint', $data);

        $response = $I->runApp('PUT', '/sprint/256', ['nb_days' => 10, 'name' => 'new sprint']);
        $I->assertEquals(200, $response->getStatusCode());

        $I->seeInDatabase('sprint', [
            'sprint_id' => 256,
            'name'      => 'new sprint',
            'nb_days'   => 10
        ]);

        $updated_at = $I->grabFromDatabase('sprint', 'updated_at', ['sprint_id' => 256]);
        $I->assertNotEmpty('2017-01-14 23:00:00', $updated_at);
    }

    public function testDeleteSprint(\FunctionalTester $I)
    {
        $data = [
            'name' => 'Sprint #256',
            'sprint_id' => 256,
            'nb_days' => 8,
            'created_at' => '2017-01-14 20:00:00',
            'updated_at' => '2017-01-14 23:00:00'
        ];
        $I->haveInDatabase('sprint', $data);

        $response = $I->runApp('DELETE', '/sprint/256');
        $I->assertEquals(200, $response->getStatusCode());

        // Row still in Database with same values :
        $I->seeInDatabase('sprint', [
            'name' => 'Sprint #256',
            'sprint_id' => 256,
            'nb_days' => 8,
            'created_at' => '2017-01-14 20:00:00',
        ]);
        $deleted_at = $I->grabFromDatabase('sprint', 'deleted_at', ['sprint_id' => 256]);
        $I->assertNotEmpty($deleted_at);
    }
}
