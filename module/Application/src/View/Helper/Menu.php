<?php

namespace Application\View\Helper;

use Exception;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplateMapResolver;
use Throwable;
use User\Service\RbacManager;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{

    /**
     * Menu items.
     * @var array
     */
    protected array $items = [];

    /** @var string */
    private string $layout = 'main';

    /** @var string */
    protected string $activeItemId = '';

    /**
     * RBAC manager.
     * @var RbacManager
     */
    private RbacManager $rbacManager;
    /**
     * @var mixed
     */
    private mixed $menuRepository;
    /**
     * @var mixed
     */
    private mixed $permissionRepository;

    private mixed $layoutService;

    /**
     * @param $rbacManager
     * @param $menuRepository
     * @param $permissionRepository
     * @param $layoutService
     */
    public function __construct(
        $rbacManager,
        $menuRepository,
        $permissionRepository,
        $layoutService,
    )
    {
        $this->rbacManager          = $rbacManager;
        $this->menuRepository       = $menuRepository;
        $this->permissionRepository = $permissionRepository;
        $this->layoutService        = $layoutService;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function setActiveItemId(string $activeItemId): void
    {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the view using the specified menu and layout.
     *
     * @param string $menu The menu to be rendered.
     * @param string $layout The layout to be used for rendering.
     * @return string The rendered view as a string.
     */
    public function render(string $menu, string $layout): string
    {
        $this->layout = $layout;
        if (count($this->items) === 0) {
            $this->items = $this->getMenuItems($menu);
        }

        return $this->layoutService->loadView($this->layout, $this->items);

    }


    /**
     * @throws Throwable
     */
    public function getMenuItems($menu): array
    {
        try {
            $items = [];
            $menuItems = $this->menuRepository->getItemByName($menu);
            foreach ($menuItems->getMenuItems() as $item) {
                $dropdown = [];
                if (count($item->getChildren() ?? []) > 0) {
                    foreach ($item->getChildren() as $childItem) {
                        $dropdown[] = [
                            'id' => $childItem->getMenuId(),
                            'label' => $childItem->getLabel(),
                            'link' => $childItem->getLink(),
                            'icon' => $childItem->getIcon()
                        ];
                    }
                }

                $permission = $this->permissionRepository->find($item->getAuthorizedFor());

                if (empty($permission) || $this->rbacManager->isGranted(null, $permission->getName())) {
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
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
