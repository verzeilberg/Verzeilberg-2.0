<?php

namespace Application\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Laminas\Crypt\Password\Bcrypt;
use User\Entity\Role;
use User\Entity\User;
use function date;

class UserDataFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('sander@verzeilberg.nl');
        $user->setFullName('Sander');

        // Encrypt password and store the password in encrypted state.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create('Gravity35#');
        $user->setPassword($passwordHash);
        $user->setStatus(1);
        $currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);
        $role = $manager->getRepository(Role::class)->find(1);
        $user->addRole($role);

        $manager->persist($user);
        $manager->flush();
    }
}