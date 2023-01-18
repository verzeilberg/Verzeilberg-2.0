<?php

namespace Application\DataFixtures;

use Application\Entity\Menu\Menu;
use Application\Entity\Menu\MenuItem;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class MenuDataFixture extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $menuItems = [
            1 => [
                'name' => 'Beheer',
            ],
            2 => [
                'name' => 'Main',
            ]
        ];

        foreach ($menuItems as $index => $menuItem) {
            $newMenuItem = new Menu();
            $newMenuItem->setId($index);
            $newMenuItem->setName($menuItem['name']);
            $newMenuItem->setDateCreated(new DateTime());

            if ($index === 1) {
                $items = $manager->getRepository(MenuItem::class)->findAll();

                foreach ($items as $item) {
                    $newMenuItem->addMenuItem($item);
                }
            }

            $manager->persist($newMenuItem);
            $manager->flush();
        }



    }

    public function getOrder(): int
    {
        return 20;
    }
}