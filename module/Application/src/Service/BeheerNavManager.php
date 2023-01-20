<?php

namespace Application\Service;

use Application\Repository\MenuRepository;
use Laminas\Router\RouteInterface;
use Laminas\Authentication\AuthenticationService;
/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class BeheerNavManager
{

    /** @var AuthenticationService */
    private AuthenticationService $authService;
    /** @var RouteInterface */
    private RouteInterface $router;
    private $rbacManager;
    /** @var MenuRepository */
    private MenuRepository $menuRepository;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $router, $rbacManager, $menuRepository)
    {
        $this->authService = $authService;
        $this->router = $router;
        $this->rbacManager = $rbacManager;
        $this->menuRepository = $menuRepository;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems($menu): array
    {
        //$this->authService->hasIdentity()
        //$this->rbacManager->isGranted(null, 'beheer.manage')
        $items = [];
        $menuItems = $this->menuRepository->getItemByName($menu);
        foreach ($menuItems->getMenuItems() as $item) {
            $items[] = [
                'id' => $item->getMenuId(),
                'label' => $item->getLabel(),
                'link' => $item->getLink(),
                'icon' => $item->getIcon()
            ];
        }

        return $items;
    }

}
