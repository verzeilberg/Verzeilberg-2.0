<?php

namespace Application\DataFixtures;

use Application\Entity\Menu\Menu;
use Application\Entity\Menu\MenuItem;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use function date;

class MenuItemDataFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * Create Menu items
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {

        $menuItems = [
            1 => [
                'id' => 'beheer',
                'label' => 'Beheer',
                'link' => '',
                'icon' => 'fa-thin fa-bars-progress',
                'authorizedFor' => 'beheer.manage'
            ],
            2 => [
                'id' => 'email',
                'label' => 'E-mail',
                'link' => '',
                'icon' => 'fa-thin fa-envelope',
                'authorizedFor' => 'email.manage'
            ],
            3 => [
                'id' => 'agenda',
                'label' => 'Agenda',
                'link' => '',
                'icon' => 'fa-thin fa-calendar-days',
                'authorizedFor' => 'agenda.manage'
            ],
            4 => [
                'id' => 'strava',
                'label' => 'Strava',
                'link' => '',
                'icon' => 'fa-brands fa-strava',
                'authorizedFor' => 'strava.manage'
            ],
            5 => [
                'id' => 'users',
                'label' => 'Users',
                'link' => '',
                'icon' => 'fa-thin fa-users',
                'authorizedFor' => 'user.manage'
            ],
            6 => [
                'id' => 'permissions',
                'label' => 'Permissions',
                'link' => '',
                'icon' => 'fa-light fa-octagon-exclamation',
                'authorizedFor' => 'permission.manage'
            ],
            7 => [
                'id' => 'roles',
                'label' => 'Roles',
                'link' => '',
                'icon' => 'fa-thin fa-address-book',
                'authorizedFor' => 'role.manage'
            ],
            8 => [
                'id' => 'blogs',
                'label' => 'Blogs',
                'link' => '',
                'icon' => 'fa-light fa-square-rss',
                'authorizedFor' => 'blog.manage'
            ],
            9 => [
                'id' => 'categories',
                'label' => 'Categories',
                'link' => '',
                'icon' => 'fa-thin fa-list',
                'authorizedFor' => 'blog.manage'
            ],
            10 => [
                'id' => 'contact',
                'label' => 'Contact',
                'link' => '',
                'icon' => 'fa-thin fa-address-card',
                'authorizedFor' => 'contact.manage'
            ],
            11 => [
                'id' => 'search',
                'label' => 'Search',
                'link' => '',
                'icon' => 'fa-thin fa-magnifying-glass',
                'authorizedFor' => 'search.manage'
            ],
            12 => [
                'id' => 'events',
                'label' => 'Events',
                'link' => '',
                'icon' => 'fa-thin fa-ranking-star',
                'authorizedFor' => 'event.manage'
            ],
            13 => [
                'id' => 'checklists',
                'label' => 'Checklists',
                'link' => '',
                'icon' => 'fa-thin fa-list-check',
                'authorizedFor' => 'checklist.manage'
            ],
            14 => [
                'id' => 'images',
                'label' => 'Images',
                'link' => '',
                'icon' => 'fa-thin fa-image',
                'authorizedFor' => 'images.manage'
            ],
            15 => [
                'id' => 'naarwebsite',
                'label' => 'Naar website',
                'link' => 'http://verzeilberg-dev',
                'icon' => 'fa-thin fa-house',
                'authorizedFor' => ''
            ],

        ];

        foreach ($menuItems as $index => $menuItem) {
            $newMenuItem = new MenuItem();
            $newMenuItem->setId($index);
            $newMenuItem->setMenuId($menuItem['id']);
            $newMenuItem->setLabel($menuItem['label']);
            $newMenuItem->setLink($menuItem['link']);
            $newMenuItem->setIcon($menuItem['icon']);
            $newMenuItem->setAuthorizedFor($menuItem['authorizedFor']);
            $newMenuItem->setDateCreated(new \DateTime());

            $manager->persist($newMenuItem);
            $manager->flush();

        }

    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 10;
    }
}