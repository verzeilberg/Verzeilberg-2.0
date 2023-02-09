<?php
namespace SteamApi;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
        'aliases' => [
            'steamindex' => Controller\IndexController::class
        ],
    ],
    'router' => [
        'routes' => [
            'SteamApi' => [
                'type'    => 'segment',
                'options' => [
                    // Change this to something specific to your module
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
];
