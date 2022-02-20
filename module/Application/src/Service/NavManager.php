<?php

namespace Application\Service;

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
    public function __construct($authService, $urlHelper, $rbacManager) {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() {
        $url = $this->urlHelper;
        $items = [];

        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link' => $url('home'),
            'fragment' => 'top'
        ];

        $items[] = [
            'id' => 'about',
            'label' => 'Over',
            'link' => $url('home'),
            'fragment' => 'about'
        ];

        $items[] = [
            'id' => 'runstats',
            'label' => 'Run stats',
            'link' => $url('home'),
            'fragment' => 'stravaOverview'
        ];
        
        $items[] = [
            'id' => 'tweets',
            'label' => 'Tweets',
            'link' => $url('home'),
            'fragment' => 'tweets'
        ];
        
        $items[] = [
            'id' => 'event',
            'label' => 'Event',
            'link' => $url('home'),
            'fragment' => 'event'
        ];

        $items[] = [
            'id' => 'blog',
            'label' => 'Blog',
            'link' => $url('home'),
            'fragment' => 'blog'
        ];
        
        $items[] = [
            'id' => 'contact',
            'label' => 'Contact',
            'link' => $url('home'),
            'fragment' => 'contact'
        ];

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

            $dropDownItems = [];

            if ($this->rbacManager->isGranted(null, 'beheer.manage')) {
                $dropDownItems[] = [
                    'id' => 'beheer',
                    'label' => 'Beheer',
                    'link' => $url('beheer')
                ];
            }


            $dropDownItems[] = [
                'id' => 'logout',
                'label' => 'Sign out',
                'link' => $url('logout')
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
