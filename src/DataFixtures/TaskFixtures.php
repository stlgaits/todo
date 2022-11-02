<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $anonymousAuthor = $this->getReference(UserFixtures::getReferenceKey('user_fsociety'));
        for ($i = 0 ; $i < 15 ; $i++) {
            $createdAt = $faker->dateTimeThisDecade();
            $task = new Task();
            $task->setTitle($faker->sentence())
                ->setContent($faker->paragraph())
                ->setCreatedAt($createdAt)
                ->toggle($faker->boolean(50))
                ->setAuthor($anonymousAuthor)
            ;
            $manager->persist($task);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
