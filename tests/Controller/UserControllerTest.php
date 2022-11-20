<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Test\CustomTestCase;
use App\Entity\User;

/**
 * @group security
 * @covers  App\Controller\UserController
 * @uses \App\Entity\User
 * @uses \App\Security\Voter\TaskVoter
 */
final class UserControllerTest extends CustomTestCase
{
    /**
     * @covers \App\Controller\UserController::list
     */
    public function testOnlyAdminUsersCanAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $user = $this->createAdminUser("mario", "notluigi", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers \App\Controller\UserController::list
     */
    public function testAnonymousUserCannotAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/users');
        // instead of throwing a 401, the user should be redirected towards the homepage
        $this->assertResponseStatusCodeSame(302);
    }

    /**
     * @covers \App\Controller\UserController::list
     */
    public function testNonAdminUserCannotAccessUsersListPage(): void
    {
        $client = $this->createClient();
        $user = $this->createUser("mario", "notluigi", "mario.bros@nintendo.fr");
        $client->loginUser($user);
        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * @covers \App\Controller\UserController::create
     * @uses \App\Form\UserType
     */
    public function testAdminUserCanCreateNewUser(): void
    {
        $client = $this->createClient();
        $userRepository = $this->getEntityManager()->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($user);
        $client->request('GET', '/users/create');
        $client->submitForm('Ajouter', [
            'user[username]' => 'ciloutest',
            'user[password][first]' => 'monpotdemasse',
            'user[password][second]' => 'monpotdemasse',
            'user[email]' => 'ciloutest@gmail.com',
            'user[roles]' => 'ROLE_USER',
        ]);
        $client->followRedirects();
        $this->assertResponseRedirects('/users', 302);
        $this->assertNotNull($userRepository->findOneBy(['username' => 'ciloutest']));
    }

    /**
     * @covers \App\Controller\UserController::create
     */
    public function testNonAdminUserCannotCreateNewUser(): void
    {
        $client = $this->createClient();
        $userRepository = $this->getEntityManager()->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => 'simpleuser']);
        $client->loginUser($user);
        $client->request('GET', '/users/create');
        $client->followRedirects();
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * @covers \App\Controller\UserController::edit
     */
    public function testAdminUserCanEditAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers \App\Controller\UserController::edit
     */
    public function testAdminUserCanPromoteAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers \App\Controller\UserController::edit
     */
    public function testAdminUserCanDemoteAnotherUser(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers \App\Controller\UserController::edit
     */
    public function testNonAdminUserCannotEditAnotherUser(): void
    {
        $this->markTestIncomplete();
    }
}
