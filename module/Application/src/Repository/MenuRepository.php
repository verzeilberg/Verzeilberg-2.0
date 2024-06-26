<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Menu;
use Exception;

class MenuRepository extends EntityRepository
{
    /**
     * Get menu by id
     * @param null $menuId
     * @return Menu
     */
    public function getItemById($menuId = null): Menu
    {
        return $this->find($menuId);
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
     * @return Menu
     */
    public function create(): Menu
    {
        return new Menu();
    }

    /*
     * Save activity to database
     * @params      $activity object
     * @return      object
     */
    public function save($menu): bool
    {
        try {
            $this->getEntityManager()->persist($menu);
            $this->getEntityManager()->flush();
            return $menu;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete a Menu object from database
     * @param $menu
     * @return bool
     */
    public function remove($menu): bool
    {
        try {
            $this->getEntityManager()->remove($menu);
            $this->getEntityManager()->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
