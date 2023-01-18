<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class BeheerMenu extends AbstractHelper
{
    /** @var array */
    protected array $items = [];
    /** @var string */
    protected string $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId(string $activeItemId): void
    {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render($menu): string
    {
        if (count($this->items) === 0) {
            return '';
        }

        $result = '';
        // Render items
        foreach ($this->items as $item) {
            $result .= $this->renderItem($item);
        }

        return $result;
    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem(array $item): string
    {
        $result = '';
        $escapeHtml = $this->getView()->plugin('escapeHtml');
        $link = $item['link'] ?? '#';
        $label = $item['label'] ?? '';
        $icon = $item['icon']? '<i class="far '.$item['icon'].' me-2"></i>':'';

        if (isset($item['dropdown'])) { //Menu has subitems

            $dropdownItems = $item['dropdown'];

            $result  = '<div class="nav-item dropdown">';
            $result .= '<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">'.$icon.$escapeHtml($label).'</a>';
            $result .= '<div class="dropdown-menu bg-transparent border-0">';
            foreach ($dropdownItems as $dropdownItem) {
                $dropDownLink  = $dropdownItem['link'] ?? '#';
                $dropDownlabel = $dropdownItem['label'] ?? '';

                $result .= '<a href="'.$escapeHtml($dropDownLink).'" class="dropdown-item">'.$escapeHtml($dropDownlabel).'</a>';
            }

            $result .= '</div></div>';
        } else { //Menu has no sub items
            $result .= '<a href="'.$escapeHtml($link).'" class="nav-item nav-link">'.$icon.$escapeHtml($label).'</a>';
        }

        return $result;
    }
}
