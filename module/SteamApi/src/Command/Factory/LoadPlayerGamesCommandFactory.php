<?php

namespace SteamApi\Command\Factory;

use Interop\Container\ContainerInterface;
use SteamApi\Command\LoadPlayerGamesCommand;
use SteamApi\Service\steamGameService;
use SteamApi\Service\steamPlayerAchievementsService;
use SteamApi\Service\steamPlayerService;

/**
 * This is the factory class for NavManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class LoadPlayerGamesCommandFactory
{

    /**
     * This method creates the LoadFixturesCommand and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): LoadPlayerGamesCommand
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $config                         = $container->get('config');
        $steamGameService               = new steamGameService();
        $steamPlayerAchievementsService = new steamPlayerAchievementsService($config);
        $steamPlayerService             = new steamPlayerService($config, $steamGameService, $steamPlayerAchievementsService);
        return new LoadPlayerGamesCommand($entityManager, $steamPlayerService);
    }
}
