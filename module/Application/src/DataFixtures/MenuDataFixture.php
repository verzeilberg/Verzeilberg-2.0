<?php

namespace Application\DataFixtures;

use Application\Entity\Menu;
use Application\Entity\MenuItem;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MenuDataFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * Create Beheer menu and add beheer menu items
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $newMenuItem = new Menu();
        $newMenuItem->setId(1);
        $newMenuItem->setName('Beheer');
        $newMenuItem->setDateCreated(new DateTime());

        $items = $manager->getRepository(MenuItem::class)->findAll();
        foreach ($items as $item) {
            $newMenuItem->addMenuItem($item);
        }

        $manager->persist($newMenuItem);
        $manager->flush();


    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 20;
    }
}