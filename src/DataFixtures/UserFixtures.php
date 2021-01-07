<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $contributor = new User();
        $faker = Faker\Factory::create('fr_FR');
        $contributor->setUsername($faker->userName);
        $contributor->setBio($faker->text);
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor, 'contributorpassword'
        ));

        $manager->persist($contributor);
        $this->addReference('contributor', $contributor);

        $admin = new User();
        $faker = Faker\Factory::create('fr_FR');
        $admin->setUsername($faker->userName);
        $admin->setBio($faker->text);
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin, 'adminpassword'
        ));

        $manager->persist($admin);


        $manager->flush();
    }


}
