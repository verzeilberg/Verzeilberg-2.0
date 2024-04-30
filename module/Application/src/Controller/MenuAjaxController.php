<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Repository\MenuItemRepository;
use Application\Repository\MenuRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Symfony\Component\VarDumper\VarDumper;
use function count;

class MenuAjaxController extends AbstractActionController
{

    protected $entityManager;

    protected $viewHelperManager;

    /**
     * @var MenuRepository
     */
    protected MenuRepository $menuRepository;

    /**
     * @var MenuItemRepository
     */
    protected MenuItemRepository $menuItemRepository;

    /**
     * @param $entityManager
     * @param $viewHelperManager
     * @param $menuRepository
     */
    public function __construct(
        $entityManager,
        $viewHelperManager,
        $menuRepository,
        $menuItemRepository
    ) {

        $this->entityManager        = $entityManager;
        $this->viewHelperManager    = $viewHelperManager;
        $this->menuRepository       = $menuRepository;
        $this->menuItemRepository   = $menuItemRepository;
    }

    public function orderMenuItemsAction()
    {
        $success = true;
        $errorMessage = '';
        $menuItems = $this->params()->fromPost('list', '');

        $this->saveMenuItems($menuItems);

        return new JsonModel([
            'success' => $success,
            'errorMessage' => $errorMessage
        ]);

    }

    public function deleteMenuItemAction()
    {
        $success = true;
        $errorMessage = 'Item verwijderd!';
        $menuItemId = $this->params()->fromPost('menuitemid', 0);
        $menuId     = $this->params()->fromPost('menuid', 0);
        $menuItem   = $this->menuItemRepository->find($menuItemId);

       // @todo add try catch

        if (!$menuItem) {
            $success = false;
            $errorMessage = 'Menu item niet gevonden!';
        }
        $menu = $this->menuRepository->getItemById($menuId);
        if (!$menu) {
            $success = false;
            $errorMessage = 'Menu niet gevonden!';
        }
        $menuItem->removeMenu($menu);
        $result = $this->menuItemRepository->remove($menuItem);
        if (!$result) {
            $success = false;
            $errorMessage = 'Item niet verwijderd!';
        }

        return new JsonModel([
            'success' => $success,
            'errorMessage' => $errorMessage,
            'menuItemId' => $menuItemId
        ]);
    }


    /**
     * @param $menuItems
     * @param $parentMenuItem
     * @return void
     */
    private function saveMenuItems($menuItems, $parentMenuItem = null): void
    {
        foreach($menuItems AS $index => $menuItemId) {
            $sortOrder = $index + 1;
            $menuItem = $this->menuItemRepository->find($menuItemId['id']);
            $menuItem->setSortOrder($sortOrder);
            if(empty($parentMenuItem)) {
                $menuItem->setParent(null);
            } else {
                $menuItem->setParent($parentMenuItem);
            }

            $this->menuItemRepository->save($menuItem);

            if (count($menuItemId["children"]??[]) > 0) {
                $this->saveMenuItems($menuItemId["children"], $menuItem);
            }
        }
    }

}
