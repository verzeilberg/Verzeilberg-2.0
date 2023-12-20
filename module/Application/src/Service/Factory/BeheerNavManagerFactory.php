<?php

namespace Application\Service\Factory;

use Application\Entity\Menu;
use Interop\Container\ContainerInterface;
use Application\Service\BeheerNavManager;
use User\Entity\Permission;
use User\Service\RbacManager;

/**
 * This is the factory class for NavManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class BeheerNavManagerFactory
{

    /**
     * This method creates the NavManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): BeheerNavManager
    {
        $rbacManager        = $container->get(RbacManager::class);
        $entityManager      = $container->get('doctrine.entitymanager.orm_default');
        $menuRepository    = $entityManager->getRepository(Menu::class);
        $permissionRepository = $entityManager->getRepository(Permission::class);
        return new BeheerNavManager(
            $rbacManager,
            $menuRepository,
            $permissionRepository
        );
    }
}
