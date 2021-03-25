<?php

namespace App\DataFixtures;
use App\Entity\Role;
use App\Entity\User5;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
  
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
          
    }
    public function load(ObjectManager $manager)
    {
      
          
        $user = new User5();
        $manager->persist($user);

        $manager->flush();
    }
}
