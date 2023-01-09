<?php

namespace Application\Service;

use Laminas\Router\RouteInterface;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager {

    /**
     * Auth service.
     * @var Laminas\Authentication\Authentication
     */
    private $authService;

    /**
     * @var RouteInterface
     */
    private $router;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $router, $rbacManager) {
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
        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link' => $this->router->getRoute('home')->assemble()
        ];

        $items[] = [
            'id' => 'blog',
            'label' => 'Blog',
            'link' =>  $this->router->getRoute('blog')->assemble()
        ];


        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link' =>  $this->router->getRoute('login')->assemble(),
                'float' => 'right'
            ];
        } else {

            $dropDownItems = [];

            if ($this->rbacManager->isGranted(null, 'beheer.manage')) {
                $dropDownItems[] = [
                    'id' => 'beheer',
                    'label' => 'Beheer',
                    'link' =>  $this->router->getRoute('beheer')->assemble()
                ];
            }


            $dropDownItems[] = [
                'id' => 'logout',
                'label' => 'Sign out',
                'link' =>  $this->router->getRoute('logouts')->assemble()
            ];

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => $dropDownItems
            ];
        }

        return $items;
    }

}
