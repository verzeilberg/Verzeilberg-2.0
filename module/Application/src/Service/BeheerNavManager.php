<?php

namespace Application\Service;

use Application\Repository\MenuRepository;
use Symfony\Component\VarDumper\VarDumper;
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

    private $permissionRepository;

    /**
     * Constructs the service.
     */
    public function __construct($rbacManager, $menuRepository, $permissionRepository)
    {
        $this->rbacManager = $rbacManager;
        $this->menuRepository = $menuRepository;
        $this->permissionRepository = $permissionRepository;
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
            $dropdown = [];
            if (count($item->getChildren()??[]) > 0) {
                foreach($item->getChildren() as $childItem) {
                    $dropdown[] = [
                        'id' => $childItem->getMenuId(),
                        'label' => $childItem->getLabel(),
                        'link' => $childItem->getLink(),
                        'icon' => $childItem->getIcon()
                    ];
                }
            }

            $permission = $this->permissionRepository->find($item->getAuthorizedFor());
            if (empty($permission->getName()) || $this->rbacManager->isGranted(null, $permission->getName())) {
                $items[] = [
                    'id' => $item->getMenuId(),
                    'label' => $item->getLabel(),
                    'link' => $item->getLink(),
                    'icon' => $item->getIcon(),
                    'dropdown' => $dropdown,
                ];

            }
        }

        return $items;
    }

}
