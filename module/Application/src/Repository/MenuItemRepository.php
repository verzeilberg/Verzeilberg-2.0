<?php

namespace Application\Repository;

use Application\Entity\MenuItem;
use Doctrine\ORM\EntityRepository;
use Application\Entity\Menu;
use Exception;

class MenuItemRepository extends EntityRepository
{
    /**
     * Get menu by id
     * @return object
     * @var $activityId
     */
    public function getItemById($menuId = null): object
    {
        return $this->findBy($menuId);
    }

    /**
     * Get menu by id
     * @return object
     * @var $activityId
     */
    public function getItemByName($name = null): object
    {
        return $this->findOneBy(['name' => $name], []);
    }

    /**
     * Create a new Menu object
     * @return MenuItem
     */
    public function create(): MenuItem
    {
        return new MenuItem();
    }

    /*
     * Save activity to database
     * @params      $activity object
     * @return      object
     */
    public function save($menuItem): mixed
    {
        try {
            $this->getEntityManager()->persist($menuItem);
            $this->getEntityManager()->flush();
            return $menuItem;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete a Menu object from database
     * @param $menu
     * @return bool
     */
    public function remove($menuItem): bool
    {
        try {
            $this->getEntityManager()->remove($menuItem);
            $this->getEntityManager()->flush();
            return true;
        } catch (Exception $e) {
            var_dump($e->getMessage()); die;
            return false;
        }
    }

}
