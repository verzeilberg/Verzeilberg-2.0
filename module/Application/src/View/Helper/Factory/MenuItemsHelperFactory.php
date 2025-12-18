<?php
namespace Application\View\Helper\Factory;

use Application\View\Helper\MenuItemsHelper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * MenuItemsHelperFactory class responsible for creating instances of MenuItemsHelper.
 */
class MenuItemsHelperFactory implements FactoryInterface
{
    /**
     * Invokes the method to create and return an instance of MenuItemsHelper.
     *
     * @param ContainerInterface $container The container to retrieve dependencies.
     * @param string $requestedName The name of the requested service.
     * @param array|null $options Any additional options to use in service creation.
     * @return MenuItemsHelper The instantiated MenuItemsHelper.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): MenuItemsHelper
    {
        // Instantiate the helper.
        return new MenuItemsHelper();
    }
}
