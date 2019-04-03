<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class Userfixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('MichelForever');
        $user->setEmail('Papillon@Delumiere');
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);
        $password = $this->encoder->encodePassword($user, 'cotorep');
        $user->setPassword($password);
        $manager->persist($user);
    }
}
