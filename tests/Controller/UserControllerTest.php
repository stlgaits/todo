<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

class UserControllerTest extends CustomTestCase
{
    public function testCanAccessUsersListPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
    }

    public function testOnlyAdminUsersCanAccessUsersListPage(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testAnonymousUserCannotAccessUsersListPage(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testNonAdminUserCannotAccessUsersListPage(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminUserCanCreateNewUser(): void
    {
        $this->markTestIncomplete();
    }

    public function testNonAdminUserCannotCreateNewUser(): void
    {
        $this->markTestIncomplete();
    }

    public function testAdminUserCanEditAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    public function testAdminUserCanPromoteAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    public function testAdminUserCanDemoteAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    public function testNonAdminUserCannotEditAnotherUser(): void
    {
        $this->markTestIncomplete();
    }
}
