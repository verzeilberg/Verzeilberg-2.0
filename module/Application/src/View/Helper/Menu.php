<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper {

    /**
     * Menu items array.
     * @var array 
     */
    protected $items = [];

    /**
     * Active item's ID.
     * @var string  
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items = []) {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items) {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render() {
        if (count($this->items) == 0)
            return ''; // Do nothing if there are no items.
        
        $result = '<a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle">';
        $result .= '<i class="fas fa-bars"></i>';
        $result .= '</a>';
        $result .= '<nav id="sidebar-wrapper">';
        $result .= '<ul class="sidebar-nav">';
        $result .= '<a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle">';
        $result .= '<i class="fa fa-times"></i>';
        $result .= '</a>';

        // Render items
        foreach ($this->items as $item) {
                $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        $result .= '</nav>';

        return $result;
    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item) {
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id == $this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li role="presentation" class="dropdown ' . ($isActive ? 'active' : '') . ' ">';
            $result .= '<a href="#" class="dropdown-toggle">';
            $result .= $escapeHtml($label) . ' <b class="caret"></b>';
            $result .= '</a>';

            $result .= '<ul class="dropdown">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';
                $fragment = isset($item['fragment']) ? '#' . $item['fragment'] : '';

                $result .= '<li class="js-scroll-trigger">';
                $result .= '<a href="' . $escapeHtml($link . $fragment) . '">' . $escapeHtml($label) . '</a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
            $result .= '</li>';
        } else {
            $link = isset($item['link']) ? $item['link'] : '#';
            $fragment = isset($item['fragment']) ? '#' . $item['fragment'] : '';

            $result .= $isActive ? '<li class="js-scroll-trigger">' : '<li class="js-scroll-trigger">';
            $result .= '<a href="' . $escapeHtml($link . $fragment) . '" class="js-scroll-trigger">' . $escapeHtml($label) . '</a>';
            $result .= '</li>';
        }

        return $result;
    }

}
