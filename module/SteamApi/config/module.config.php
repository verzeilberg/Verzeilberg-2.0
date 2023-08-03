<?php
namespace SteamApi;

use SteamApi\Command\LoadPlayerGamesCommand;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'laminas-cli' => [
        'commands' => [
            'verzeilberg:import-player-games' => LoadPlayerGamesCommand::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
        'aliases' => [
            'steamindex' => Controller\IndexController::class
        ],
    ],
    'service_manager' => [
        'factories' => [
            Command\LoadPlayerGamesCommand::class => Command\Factory\LoadPlayerGamesCommandFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'SteamApi' => [
                'type'    => 'segment',
                'options' => [
                    'route' => '/steam[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller'    => 'steamindex',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            'steamindex' => [
                ['actions' => '*', 'allow' => '*']
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'steamapi' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'steamApi' => [
        'url' => 'https://api.steampowered.com',
        'Steam-Web-API-key' => '',
        'Steam-id' => '',
        'format' => '', #json/xml
        'version' => 'v0001'
    ],
];
