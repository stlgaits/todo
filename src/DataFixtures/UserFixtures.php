<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected UserPasswordHasherInterface $hasher;
    private ContainerBagInterface $params;

    public function __construct(UserPasswordHasherInterface $hasher, ContainerBagInterface $params)
    {
        $this->hasher = $hasher;
        $this->params = $params;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 15; ++$i) {
            $user = new User();
            $password = $faker->word();
            $user->setUsername($faker->userName())
                ->setEmail($faker->email())
                ->setPassword($this->hasher->hashPassword($user, $password));
            $this->addReference(self::getReferenceKey($i), $user);
            $manager->persist($user);
        }

        // Create 1 Admin User
        $admin = $this->addAdmin();
        $manager->persist($admin);

        $manager->flush();
    }

    public function addAdmin(): User
    {
        $admin = new User();
        $admin->setEmail($this->params->get('admin_email_address'))
            ->setUsername($this->params->get('admin_username'))
            ->setPassword($this->hasher->hashPassword($admin, $this->params->get('admin_password')))
            ->setRoles(['ROLE_ADMIN']);

        return $admin;
    }

    public static function getReferenceKey($key): string
    {
        return sprintf('user_%s', $key);
    }
}
