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

        $user->setUsername('nani');
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

        $product = new User();
        $product->setUsername('yes');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('no');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('si');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('da');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('nein');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('tak');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('nie');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('non');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('niet');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('hay');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('ie');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);

        $product = new User();
        $product->setUsername('yebo');
        $product->setEmail('oui@non.non');
        $product->setPassword($this->passwordEncoder->encodePassword($product,'fifo'));
        $manager->persist($product);


        $manager->flush();
    }
}
