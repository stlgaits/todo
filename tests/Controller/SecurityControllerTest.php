<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

class SecurityControllerTest extends CustomTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLogout(): void
    {
        $this->markTestSkipped();
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');
        // this isn't the correct assertion but I don't know which one to use to test a controller method which should never
        // be reached nor return anything....
        $this->assertResponseIsUnprocessable();
    }
}
