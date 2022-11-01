<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;

/**
 * @group security
 */
final class UserControllerTest extends CustomTestCase
{
    public function testOnlyAdminUsersCanAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $user = $this->createAdminUser("mario", "notluigi", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testAnonymousUserCannotAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/users');
        // instead of throwing a 401, the user should be redirected towards the homepage
        $this->assertResponseStatusCodeSame(302);
    }

    public function testNonAdminUserCannotAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("mario", "notluigi", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminUserCanCreateNewUser(): void
    {
        $client = $this->createClient();
        $user = $this->createAdminUser("IamAdmin", "mysupersecureadminpwd", "admin@gmail.com");
        $client->loginUser($user);
        $client->request('GET', '/users/create');
        $this->markTestIncomplete();
        // @TODO: submit form & test whether new user is persisted in database
//        $client->submitForm('Add comment', [
//            'comment_form[content]' => '...',
//        ]);
        $this->assertResponseIsSuccessful();
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
