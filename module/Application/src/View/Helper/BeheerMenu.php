<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class BeheerMenu extends AbstractHelper
{

    /** @var array */
    protected $items = [];
    /** @var string */
    protected $activeItemId = '';

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
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId(string $activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render(): string
    {
        if (count($this->items) == 0) {
            return '';
        }

        $result = '<div class="col-md-auto">';
        $result .= '<h1>MENU</h1>';
        $result .=  '<nav class="navbar navbar-dark bg-dark">';
        $result .=      '<ul class="nav flex-column flex-nowrap w-100" id="beheerMenu">';
        // Render items
        foreach ($this->items as $item) {
            if (!isset($item['float'])) {
                $result .= $this->renderItem($item);
            }
        }
        $result .=      '</ul>';
        $result .=  '</nav>';
        $result .= '</div>';

        return $result;
    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem(array $item): string
    {
        $id = $item['id'] ?? '';
        $isActive = ($id == $this->activeItemId);
        $label = $item['label'] ?? '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) { //Menu has subitems

            $dropdownItems = $item['dropdown'];
            
            $result .= '<li class="nav-item w-100">';
            $result .=      '<a href="#" class="nav-link collapsed text-white" data-toggle="collapse" data-target="#submenu'.$id.'">';
            $result .=          $escapeHtml($label) . ' ' . $this->activeItemId;
            $result .=      '</a>';


            $result .= '<div class="collapse" id="submenu'.$id.'" aria-expanded="false">';
            $result .=  '<ul class="flex-column pl-2 nav">';
            foreach ($dropdownItems as $item) {
                $label = $item['label'] ?? '';

                $result .= '<li class="nav-item">';
                $result .=      '<a href="' . $escapeHtml($link) . '" class="nav-link py-0 text-white">' . $escapeHtml($label) . '</a>';
                $result .= '</li>';
            }
            $result .=  '</ul>';
            $result .= '</div>';
        } else { //Menu has no sub items
            $link = $item['link'] ?? '#';
            $result .= '<li class="nav-item w-100">';
            $result .= '<a href="' . $escapeHtml($link) . '" class="nav-link text-white">' . $escapeHtml($label) . '</a>';
        }
        $result .= '</li>';

        return $result;
    }
}
