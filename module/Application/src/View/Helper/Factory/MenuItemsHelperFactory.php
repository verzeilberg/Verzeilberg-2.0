<?php
namespace Application\View\Helper\Factory;

use Application\View\Helper\MenuItemsHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for Menu view helper. Its purpose is to instantiate the
 * helper and init menu items.
 */
class MenuItemsHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Instantiate the helper.
        return new MenuItemsHelper();
    }
}
