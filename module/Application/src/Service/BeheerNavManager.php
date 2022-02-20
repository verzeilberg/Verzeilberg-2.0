<?php

namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class BeheerNavManager
{

    /**
     * Auth service.
     * @var Laminas\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var Laminas\View\Helper\Url
     */
    private $urlHelper;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];


        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link' => $url('login'),
                'float' => 'right'
            ];
        } else {

            // Determine which items must be displayed in Admin dropdown.
            $items = [];

            if ($this->rbacManager->isGranted(null, 'beheer.manage')) {
                $items[] = [
                    'id' => 'beheer',
                    'label' => 'Beheer',
                    'link' => $url('beheer')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'email.manage')) {
                $items[] = [
                    'id' => 'email',
                    'label' => 'E-mail',
                    'link' => $url('beheer/email')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'agenda.manage')) {
                $items[] = [
                    'id' => 'agenda',
                    'label' => 'Agenda',
                    'link' => $url('beheer/agenda')
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
                            'link' => $url('beheer/strava')
                        ],
                        [
                            'id' => 'activitiesstrava',
                            'label' => 'Activiteiten',
                            'link' => $url('beheer/strava', ['action' => 'activiteiten'])
                        ],
                        [
                            'id' => 'importstrava',
                            'label' => 'Import',
                            'link' => $url('beheer/stravaimport')
                        ],
                        [
                            'id' => 'importstrava',
                            'label' => 'Log',
                            'link' => $url('beheer/stravalog')
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
                            'link' => $url('beheer/users')
                        ],
                        [
                            'id' => 'adduser',
                            'label' => 'Add user',
                            'link' => $url('beheer/users', ['action' => 'add'])
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
                            'link' => $url('beheer/permissions')
                        ],
                        [
                            'id' => 'addpermission',
                            'label' => 'Add permission',
                            'link' => $url('beheer/permissions', ['action' => 'add'])
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
                            'link' => $url('beheer/roles')
                        ],
                        [
                            'id' => 'addrole',
                            'label' => 'Add role',
                            'link' => $url('beheer/roles', ['action' => 'add'])
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
                            'link' => $url('beheer/blog')
                        ],
                        [
                            'id' => 'addblog',
                            'label' => 'Add blog',
                            'link' => $url('beheer/blog', ['action' => 'add'])
                        ],
                        [
                            'id' => 'archive',
                            'label' => 'Archief',
                            'link' => $url('beheer/blog', ['action' => 'archive'])
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
                            'link' => $url('beheer/categories')
                        ],
                        [
                            'id' => 'addcategory',
                            'label' => 'Add category',
                            'link' => $url('beheer/categories', ['action' => 'add'])
                        ],
                    ]
                ];
            }
            if ($this->rbacManager->isGranted(null, 'contact.manage')) {
                $items[] = [
                    'id' => 'contact',
                    'label' => 'Contact',
                    'link' => $url('beheer/contact')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'search.manage')) {
                $items[] = [
                    'id' => 'search',
                    'label' => 'Search',
                    'link' => $url('beheer/search')
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
                            'link' => $url('beheer/event')
                        ],
                        [
                            'id' => 'addevent',
                            'label' => 'Add event',
                            'link' => $url('beheer/event', ['action' => 'add'])
                        ],
                        [
                            'id' => 'archiveevent',
                            'label' => 'Archief',
                            'link' => $url('beheer/event', ['action' => 'archive'])
                        ],
                        [
                            'id' => 'eventcategories',
                            'label' => 'Categorieen',
                            'link' => $url('beheer/eventcategories')
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
                            'link' => $url('beheer/checklist')
                        ],
                        [
                            'id' => 'addchecklist',
                            'label' => 'Add checklist',
                            'link' => $url('beheer/checklist', ['action' => 'add'])
                        ],
                        [
                            'id' => 'archivechecklist',
                            'label' => 'Archief',
                            'link' => $url('beheer/checklist', ['action' => 'archive'])
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
                            'link' => $url('beheer/images')
                        ],
                        [
                            'id' => 'servercheckimages',
                            'label' => 'Server check',
                            'link' => $url('beheer/images', ['action' => 'serverCheck'])
                        ],
                        [
                            'id' => 'imagecheckimages',
                            'label' => 'File check',
                            'link' => $url('beheer/images', ['action' => 'fileCheck'])
                        ]
                    ]
                ];
            }

            $items[] = [
                'id' => 'home',
                'label' => 'Naar website',
                'link' => $url('home')
            ];
        }
        return $items;
    }

}
