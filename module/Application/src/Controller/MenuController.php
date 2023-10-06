<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\MenuItemForm;
use Application\Repository\MenuItemRepository;
use Application\Repository\MenuRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class MenuController extends AbstractActionController
{

    protected $entityManager;

    protected $viewHelperManager;

    /**
     * @var MenuItemRepository
     */
    protected $menuItemRepository;

    /**
     * @var MenuRepository
     */
    protected MenuRepository $menuRepository;
    public function __construct(
        $entityManager,
        $viewHelperManager,
        $menuRepository,
        $menuItemRepository
    ) {

        $this->entityManager        = $entityManager;
        $this->viewHelperManager    = $viewHelperManager;
        $this->menuRepository       = $menuRepository;
        $this->menuItemRepository       = $menuItemRepository;
    }

    public function indexAction()
    {
        $this->layout('layout/beheer');

        $menus = $this->menuRepository->findAll();

        return new ViewModel(
            [
                'menus' => $menus
            ]
        );
    }

    public function editAction()
    {
        $this->layout('layout/beheer');
        $this->viewHelperManager->get('headLink')->appendStylesheet('/css/menu.css');
        $this->viewHelperManager->get('headLink')->appendStylesheet('//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('headScript')->appendFile('https://code.jquery.com/ui/1.10.4/jquery-ui.min.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/jquery.ui.nestedSortable.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/menu.js');

        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('menubeheer');
        }
        $menu = $this->menuRepository->find($id);
        if (empty($menu)) {
            return $this->redirect()->toRoute('menubeheer');
        }

        return new ViewModel(
            [
                'menu' => $menu
            ]
        );
    }

    public function editMenuItemAction()
    {
        $this->layout('layout/beheer');
        $this->viewHelperManager->get('headScript')->appendFile('https://unpkg.com/codethereal-iconpicker@1.2.1/dist/iconpicker.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/menu-item.js');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('menubeheer');
        }
        $menuItem = $this->menuItemRepository->find($id);
        if (empty($menuItem)) {
            return $this->redirect()->toRoute('menubeheer');
        }

        // Create the form and inject the EntityManager
        $form = new MenuItemForm($this->entityManager);
        // Create a new, empty entity and bind it to the form
        $form->bind($menuItem);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $this->entityManager->persist($menuItem);
                $this->entityManager->flush();
                $this->flashMessenger()->addSuccessMessage('Menu item opgeslagen');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);

    }

}
