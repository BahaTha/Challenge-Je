<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   $person = new Person();
        // $product = new Product();
        // $manager->persist($product);
        $manager->persist($person);

        $manager->flush();
    }
}
