<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;



class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $roles;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('oui');
        $user->setEmail('oui@oui.oui');
        $user->setPassword('test');
        //$user->setPassword($this->passwordEncoder->encodePassword($user,'the_new_password'));
        $manager->persist($user);

        $manager->flush();
    }
}
