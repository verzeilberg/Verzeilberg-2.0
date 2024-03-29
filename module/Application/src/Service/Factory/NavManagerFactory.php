<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Application\Service\NavManager;
use User\Service\RbacManager;

/**
 * This is the factory class for NavManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class NavManagerFactory
{
    /**
     * This method creates the NavManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NavManager
    {
        $authService = $container->get(\Laminas\Authentication\AuthenticationService::class);
        $router = $container->get('Router');
        $rbacManager = $container->get(RbacManager::class);
        return new NavManager($authService, $router, $rbacManager);
    }
}
