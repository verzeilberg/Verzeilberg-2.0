<?php

namespace Application\Repository;

use Application\Entity\UserDetails;
use Doctrine\ORM\EntityRepository;
use Exception;

class UserDetailsRepository extends EntityRepository
{
    /**
     * Get menu by id
     * @param null $id
     * @return UserDetails
     */
    public function getItemById($id = null): UserDetails
    {
        return $this->find($id);
    }

    /**
     * Create a new UserDetails object
     * @return UserDetails
     */
    public function create(): UserDetails
    {
        return new UserDetails();
    }

    /*
     * Save activity to database
     * @params      $userDetails object
     * @return      object
     */
    public function save($userDetails): bool
    {
        try {
            $this->getEntityManager()->persist($userDetails);
            $this->getEntityManager()->flush();
            return $userDetails;
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
