<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\MenuItem;
use Application\Form\MenuItemForm;
use Application\Repository\MenuItemRepository;
use Application\Repository\MenuRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Symfony\Component\VarDumper\VarDumper;

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

        $menuId = (int) $this->params()->fromRoute('id', 0);
        if (empty($menuId)) {
            return $this->redirect()->toRoute('menubeheer');
        }
        $menu = $this->menuRepository->find($menuId);
        if (empty($menu)) {
            return $this->redirect()->toRoute('menubeheer');
        }

        return new ViewModel(
            [
                'menu' => $menu,
            ]
        );
    }

    public function editMenuItemAction()
    {

        $this->layout('layout/beheer');
        // Js scripts
        $this->viewHelperManager->get('headScript')->appendFile('https://unpkg.com/codethereal-iconpicker@1.2.1/dist/iconpicker.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/menu-item.js');

        $menuId = (int) $this->params()->fromRoute('id', 0);
        $id = (int) $this->params()->fromRoute('menu-id', 0);
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
            'form' => $form,
            'menuId' => $menuId
        ]);

    }

    public function addMenuItemAction()
    {

        $this->layout('layout/beheer');
        // Js scripts
        $this->viewHelperManager->get('headScript')->appendFile('https://unpkg.com/codethereal-iconpicker@1.2.1/dist/iconpicker.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/menu-item.js');

        $menuId = (int) $this->params()->fromRoute('id', 0);
        $menuItem = new MenuItem();
        // Create the form and inject the EntityManager
        $form = new MenuItemForm($this->entityManager);
        // Create a new, empty entity and bind it to the form



        $form->bind($menuItem);

        VarDumper::dump($menuItem); die;

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $menuItem->setDateCreated(new \DateTime());
                $menuItem->setCreatedBy($this->currentUser());
                $this->entityManager->persist($menuItem);
                $this->entityManager->flush();
                $this->flashMessenger()->addSuccessMessage('Menu item opgeslagen');
            }
        }

        return new ViewModel([
            'form' => $form,
            'menuId' => $menuId
        ]);
    }

}
