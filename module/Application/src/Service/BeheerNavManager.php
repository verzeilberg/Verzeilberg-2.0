<?php

namespace Application\Service;

use Application\Repository\MenuRepository;
use User\Service\RbacManager;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class BeheerNavManager
{
    /** @var RbacManager */
    private RbacManager $rbacManager;
    /** @var MenuRepository */
    private MenuRepository $menuRepository;

    /**
     * Constructs the service.
     */
    public function __construct($rbacManager, $menuRepository)
    {
        $this->rbacManager = $rbacManager;
        $this->menuRepository = $menuRepository;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     * @param $menu
     * @return array
     */
    public function getMenuItems($menu): array
    {
        $items = [];
        $menuItems = $this->menuRepository->getItemByName($menu);

        foreach ($menuItems->getMenuItems() as $item) {
            if (empty($item->getAuthorizedFor()) || $this->rbacManager->isGranted(null, $item->getAuthorizedFor())) {
                $items[] = [
                    'id' => $item->getMenuId(),
                    'label' => $item->getLabel(),
                    'link' => $item->getLink(),
                    'icon' => $item->getIcon()
                ];
            }
        }

        return $items;
    }

}
