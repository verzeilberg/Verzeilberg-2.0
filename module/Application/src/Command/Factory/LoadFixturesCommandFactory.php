<?php

namespace Application\Command\Factory;

use Interop\Container\ContainerInterface;
use Application\Command\LoadFixturesCommand;

/**
 * This is the factory class for NavManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class LoadFixturesCommandFactory
{

    /**
     * This method creates the LoadFixturesCommand and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): LoadFixturesCommand
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new LoadFixturesCommand($entityManager);
    }
}
