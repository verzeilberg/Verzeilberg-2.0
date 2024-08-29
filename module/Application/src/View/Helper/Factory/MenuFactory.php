<?php

namespace Application\View\Helper\Factory;

use Application\Service\LayoutService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Application\View\Helper\Menu;
use User\Entity\Permission;
use User\Service\RbacManager;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class MenuFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Menu
    {
        $rbacManager = $container->get(RbacManager::class);
        $entityManager          = $container->get('doctrine.entitymanager.orm_default');
        $menuRepository         = $entityManager->getRepository(\Application\Entity\Menu::class);
        $permissionRepository   = $entityManager->getRepository(Permission::class);
        $config                 = $container->get('config');
        $layoutService          = new LayoutService($config);

        // Instantiate the helper.
        return new Menu(
            $rbacManager,
            $menuRepository,
            $permissionRepository,
            $layoutService
        );
    }
}
