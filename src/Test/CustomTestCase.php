<?php

declare(strict_types=1);

namespace App\Test;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomTestCase extends  WebTestCase
{

    /*
    * @throws Exception
    */
    protected function getEntityManager(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }
}