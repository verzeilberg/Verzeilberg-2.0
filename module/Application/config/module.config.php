<?php

namespace Application;

use Application\Command\LoadFixturesCommand;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [

    'laminas-cli' => [
        'commands' => [
            'verzeilberg:load-fixtures' => LoadFixturesCommand::class,
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'beheer' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/beheer',
                    'defaults' => [
                        'controller' => Controller\BeheerController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'blog' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/blog[[/]:action[/:id]]',
                            'defaults' => [
                                'controller' => 'blogbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'categories' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/categories[/:action[/:id]]',
                            'defaults' => [
                                'controller' => 'categorybeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'roles' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/roles[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'rolebeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'permissions' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/permissions[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'permissionbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'users' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/users[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => 'userbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'contact' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/contact[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'contactbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'email' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/email[/:folder[/:page]][/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'emailbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'showEmail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/email/show[/:folder[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'emailbeheer',
                                'action' => 'showEmail',
                            ],
                        ],
                    ],
                    'showEmailBody' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/email/showbody[/:folder[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'emailbeheer',
                                'action' => 'showEmailBody',
                            ],
                        ],
                    ],
                    'manageEmailfolders' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/email/folders[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'emailbeheer',
                                'action' => 'addFolder',
                            ],
                        ],
                    ],
                    'downloadAttachment' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/email/attachement[/:folder][/:id][/:attachmentId]',
                            'constraints' => [
                                'folder' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                                'attachmentId' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'emailbeheer',
                                'action' => 'downloadFile',
                            ],
                        ],
                    ],
                    'agenda' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/agenda[/:action[/:day]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'day' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'agendabeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'search' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/search[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'searchbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'event' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/event[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'eventbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'eventcategories' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/event/categories[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'eventcategorybeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'checklist' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/checklist[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'checklistbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'checklistitem' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/checklistitem[/:action[/:id][/:checklistid]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'checklistitembeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'images' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/images[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'imagesbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'strava' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/strava[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'stravabeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'stravaimport' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/stravaimport[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'stravaimportbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'stravalog' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/stravalog[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                'controller' => 'stravalogbeheer',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'about',
                    ],
                ],
            ],
            'events' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/events[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'events',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\BeheerController::class => Controller\Factory\BeheerControllerFactory::class,
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'options' => [
            // The access filter can work in 'restrictive' (recommended) or 'permissive'
            // mode. In restrictive mode all controller actions must be explicitly listed
            // under the 'access_filter' config key, and access is denied to any not listed
            // action for not logged in users. In permissive mode, if an action is not listed
            // under the 'access_filter' key, access to it is permitted to anyone (even for
            // not logged in users. Restrictive mode is more secure and recommended to use.
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\IndexController::class => [
                // Allow anyone to visit "index" and "about" actions
                ['actions' => ['index', 'about', 'events', 'event', 'getEventLocations', 'user', 'getLocations', 'runningStats', 'getChartData', 'detail'], 'allow' => '*'],
                // Allow authorized users to visit "profiel" action
                //['actions' => ['profiel'], 'allow' => '@']
            ],
            Controller\BeheerController::class => [
                // Allow anyone to visit "index" and "about" actions
                ['actions' => ['index'], 'allow' => '+beheer.manage']
            ],
        ]
    ],
    // This key stores configuration for RBAC manager.
    'rbac_manager' => [
        'assertions' => [Service\RbacAssertionManager::class],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\NavManager::class => Service\Factory\NavManagerFactory::class,
            Service\BeheerNavManager::class => Service\Factory\BeheerNavManagerFactory::class,
            Service\RbacAssertionManager::class => Service\Factory\RbacAssertionManagerFactory::class,
            Command\LoadFixturesCommand::class => Command\Factory\LoadFixturesCommandFactory::class,
        ],
        'invokables' => [
            Service\beheerServiceInterface::class => Service\beheerService::class,
            Service\defaultServiceInterface::class => Service\defaultService::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
            View\Helper\BeheerMenu::class => View\Helper\Factory\BeheerMenuFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],
        'aliases' => [
            'mainMenu' => View\Helper\Menu::class,
            'beheerMenu' => View\Helper\BeheerMenu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // The following key allows to define custom styling for FlashMessenger view helper.
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format' => '<div%s><ul><li>',
            'message_close_string' => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        ]
    ],
    'translator' => array(
        'locale' => 'nl_NL',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
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
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];