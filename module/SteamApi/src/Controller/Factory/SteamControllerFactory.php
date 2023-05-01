<?php

namespace SteamApi\Controller\Factory;

use Interop\Container\ContainerInterface;
use Blog\Controller\BlogController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use UploadImages\Service\cropImageService;
use UploadImages\Service\imageService;
use Twitter\Service\twitterOathService;
use Twitter\Service\twitterService;
use Blog\Service\blogService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class SteamControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $ViewHelperManager = $container->get('ViewHelperManager');
        $config = $container->get('config');
        $steamService = new blogService($entityManager);
        return new SteamController(
            $entityManager,
            $ViewHelperManager,
            $steamService
        );
    }

}
