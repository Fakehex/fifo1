<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;



class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $roles = [];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('oui');
        $user->setEmail('oui@oui.oui');
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'test'));
        $manager->persist($user);

        $product = new User();
        $product->setUsername('non');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $manager->flush();
    }
}
