<?php

namespace Application\MyDataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Laminas\Crypt\Password\Bcrypt;
use User\Entity\Role;
use User\Entity\User;
use function date;

class RoleDataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $roles = [
            1 => [
                'name' => 'Administrator',
                'description' => 'A person who manages users, roles, etc.'
            ],
            2 => [
                'name' => 'Guest',
                'description' => 'A person who can log in and view own profile.'
            ]
        ];

        foreach ($roles as $role) {
            $role = new Role;
            $role->setName($role['name']);
            $role->setDescription($role['description']);
            $role->setDateCreated(date('Y-m-d H:i:s'));

            $manager->persist($role);
            $manager->flush();

        }
    }
}