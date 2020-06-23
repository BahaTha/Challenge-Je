<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Admin;
use App\Entity\User5;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Appfixtures extends Fixture
{


   public function load(ObjectManager $manager)
{
    
    $user = new Admin();

   
        

       
        $manager->persist($user);

        $manager->flush();
}
}
