<?php

namespace Application\Controller\Factory;

use Blog\Service\blogService;
use Event\Service\eventService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;
use StravaApi\Entity\Activity;
use StravaApi\Entity\ActivityImportLog;
use StravaApi\Entity\Round;
use StravaApi\Service\StravaService;
use Twitter\Service\twitterOathService;
use Twitter\Service\twitterService;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \ErrorException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): IndexController
    {
        $entityManager                  = $container->get('doctrine.entitymanager.orm_default');
        $blogService                    = new blogService($entityManager);
        $eventService                   = new eventService($entityManager);
        $config                         = $container->get('config');
        $activityRepository             = $entityManager->getRepository(Activity::class);
        $roundRepository                = $entityManager->getRepository(Round::class);
        $activityImportLogRepository    = $entityManager->getRepository(ActivityImportLog::class);
        $stravaService                  = new StravaService(
            $config,
            $activityRepository,
            $roundRepository,
            $activityImportLogRepository
        );
        $twitterService = new twitterService($config);
        $twitterOathService = new twitterOathService($config, $twitterService);

        return new IndexController(
            $blogService,
            $eventService,
            $stravaService,
            $twitterService,
            $twitterOathService
        );
    }
}
