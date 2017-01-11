<?php

/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 09/01/17
 * Time: 22:05
 */
class HomepageCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetHomepageWithoutName(FunctionalTester $I)
    {
        $response = $I->runApp('GET', '/hello/');

        $I->assertEquals(200, $response->getStatusCode());
        $I->assertContains('SlimFramework', (string)$response->getBody());
        $I->assertNotContains('Hello', (string)$response->getBody());
    }

    /**
     * Test that the index route with optional name argument returns a rendered greeting
     */
    public function testGetHomepageWithGreeting(FunctionalTester $I)
    {
        $response = $I->runApp('GET', '/hello/name');

        $I->assertEquals(200, $response->getStatusCode());
        $I->assertContains('Hello name!', (string)$response->getBody());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed(FunctionalTester $I)
    {
        $response = $I->runApp('POST', '/hello/', ['test']);

        $I->assertEquals(405, $response->getStatusCode());
        $I->assertContains('Method not allowed', (string)$response->getBody());
    }
}
