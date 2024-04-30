<?php

namespace Application\Controller\Factory;

use Application\Controller\MenuController;
use Application\Entity\Menu;
use Application\Entity\MenuItem;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MenuControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager      = $container->get('doctrine.entitymanager.orm_default');
        $viewHelperManager  = $container->get('ViewHelperManager');
        $menuRepository     = $entityManager->getRepository(Menu::class);
        $menuItemRepository = $entityManager->getRepository(MenuItem::class);
        $config             = $container->get('config');
        $routes             = $config['router']['routes'];
        return new MenuController(
            $entityManager,
            $viewHelperManager,
            $menuRepository,
            $menuItemRepository,
            $routes
        );
    }

}
