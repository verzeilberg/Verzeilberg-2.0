<?php

namespace Application\Service;

use Laminas\Router\RouteInterface;
use Laminas\Authentication\AuthenticationService;
/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class BeheerNavManager
{

    /** @var AuthenticationService */
    private $authService;
    /** @var RouteInterface */
    private $router;
    /** @var User\Service\RbacManager */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $router, $rbacManager)
    {
        $this->authService = $authService;
        $this->router = $router;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems(): array
    {
        $items = [];
        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link' => $this->router->getRoute('login')->assemble(),
                'icon' => ''
            ];
        } else {
            // Determine which items must be displayed in Admin dropdown.
            $items = [];

            if ($this->rbacManager->isGranted(null, 'beheer.manage')) {
                $items[] = [
                    'id' => 'beheer',
                    'label' => 'Beheer',
                    'link' => $this->router->getRoute('beheer')->assemble(),
                    'icon' => ''
                ];
            }

            if ($this->rbacManager->isGranted(null, 'email.manage')) {
                $items[] = [
                    'id' => 'email',
                    'label' => 'E-mail',
                    'link' => $this->router->getRoute('emailbeheer')->assemble(),
                    'icon' => ''
                ];
            }

            if ($this->rbacManager->isGranted(null, 'agenda.manage')) {
                $items[] = [
                    'id' => 'agenda',
                    'label' => 'Agenda',
                    'link' => $this->router->getRoute('agendabeheer')->assemble(),
                    'icon' => ''
                ];
            }

            if ($this->rbacManager->isGranted(null, 'strava.manage')) {
                $items[] = [
                    'id' => 'strava',
                    'label' => 'Strava',
                    'dropdown' => [
                        [
                            'id' => 'overviewstrava',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('strava')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'activitiesstrava',
                            'label' => 'Activiteiten',
                            'link' => $this->router->getRoute('strava')->assemble(['action' => 'activiteiten']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'importstrava',
                            'label' => 'Import',
                            'link' => $this->router->getRoute('stravaimport')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'importstrava',
                            'label' => 'Log',
                            'link' => $this->router->getRoute('stravalog')->assemble(),
                            'icon' => ''
                        ],
                    ]
                ];

            }

            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $items[] = [
                    'id' => 'users',
                    'label' => 'Users',
                    'dropdown' => [
                        [
                            'id' => 'overviewusers',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('users')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'adduser',
                            'label' => 'Add user',
                            'link' => $this->router->getRoute('stravalog')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                    ]
                ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $items[] = [
                    'id' => 'permissions',
                    'label' => 'Permissions',
                    'dropdown' => [
                        [
                            'id' => 'overviewpermissions',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('permissions')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addpermission',
                            'label' => 'Add permission',
                            'link' => $this->router->getRoute('permissions')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                    ]
                ];
            }

            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $items[] = [
                    'id' => 'roles',
                    'label' => 'Roles',
                    'dropdown' => [
                        [
                            'id' => 'overviewroles',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('roles')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addrole',
                            'label' => 'Add role',
                            'link' => $this->router->getRoute('roles')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                    ]
                ];
            }

            if ($this->rbacManager->isGranted(null, 'blog.manage')) {
                $items[] = [
                    'id' => 'blog',
                    'label' => 'Blogs',
                    'dropdown' => [
                        [
                            'id' => 'overviewblog',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('blog')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addblog',
                            'label' => 'Add blog',
                            'link' => $this->router->getRoute('blog')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'archive',
                            'label' => 'Archief',
                            'link' => $this->router->getRoute('blog')->assemble(['action' => 'archive']),
                            'icon' => ''
                        ],
                    ]
                ];

                $items[] = [
                    'id' => 'category',
                    'label' => 'Categories',
                    'dropdown' => [
                        [
                            'id' => 'overviewcategory',
                            'label' => 'Overview',
                            'link' => ' test', //$this->router->getRoute('categories')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addcategory',
                            'label' => 'Add category',
                            'link' => ' test', //$this->router->getRoute('categories')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                    ]
                ];
            }
            if ($this->rbacManager->isGranted(null, 'contact.manage')) {
                $items[] = [
                    'id' => 'contact',
                    'label' => 'Contact',
                    'link' => $this->router->getRoute('contact')->assemble(),
                    'icon' => ''
                ];
            }

            if ($this->rbacManager->isGranted(null, 'search.manage')) {
                $items[] = [
                    'id' => 'search',
                    'label' => 'Search',
                    'link' => $this->router->getRoute('search')->assemble(),
                    'icon' => ''
                ];
            }

            if ($this->rbacManager->isGranted(null, 'event.manage')) {
                $items[] = [
                    'id' => 'event',
                    'label' => 'Events',
                    'dropdown' => [
                        [
                            'id' => 'overviewevent',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('event')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addevent',
                            'label' => 'Add event',
                            'link' => $this->router->getRoute('event')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'archiveevent',
                            'label' => 'Archief',
                            'link' => $this->router->getRoute('event')->assemble(['action' => 'archive']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'eventcategories',
                            'label' => 'Categorieen',
                            'link' => ' test', //$this->router->getRoute('eventcategories')->assemble(),
                            'icon' => ''
                        ],
                    ]
                ];


            }

            if ($this->rbacManager->isGranted(null, 'checklist.manage')) {
                $items[] = [
                    'id' => 'checklist',
                    'label' => 'CheckLists',
                    'dropdown' => [
                        [
                            'id' => 'overviewchecklist',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('checklist')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'addchecklist',
                            'label' => 'Add checklist',
                            'link' => $this->router->getRoute('checklist')->assemble(['action' => 'add']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'archivechecklist',
                            'label' => 'Archief',
                            'link' => $this->router->getRoute('checklist')->assemble(['action' => 'archive']),
                            'icon' => ''
                        ],
                    ]
                ];
            }

            if ($this->rbacManager->isGranted(null, 'checklist.manage')) {
                $items[] = [
                    'id' => 'images',
                    'label' => 'Images',
                    'dropdown' => [
                        [
                            'id' => 'checkimages',
                            'label' => 'Overview',
                            'link' => $this->router->getRoute('images')->assemble(),
                            'icon' => ''
                        ],
                        [
                            'id' => 'servercheckimages',
                            'label' => 'Server check',
                            'link' => $this->router->getRoute('images')->assemble(['action' => 'serverCheck']),
                            'icon' => ''
                        ],
                        [
                            'id' => 'imagecheckimages',
                            'label' => 'File check',
                            'link' => $this->router->getRoute('images')->assemble(['action' => 'fileCheck']),
                            'icon' => ''
                        ]
                    ]
                ];
            }

            $items[] = [
                'id' => 'home',
                'label' => 'Naar website',
                'link' => $this->router->getRoute('home')->assemble(),
                'icon' => ''
            ];
        }
        return $items;
    }

}
