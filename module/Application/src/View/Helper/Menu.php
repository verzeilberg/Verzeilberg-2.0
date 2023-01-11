<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{

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
     * @param string $activeItemId
     * @return void
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
        $result = '';
        if (count($this->items) == 0)
            return $result; // Do nothing if there are no items.

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
        $id = $item['id'] ?? '';
        $isActive = ($id == $this->activeItemId);
        $label = $item['label'] ?? '';
        $escapeHtml = $this->getView()->plugin('escapeHtml');
        $link = $item['link'] ?? '#';
        $fragment = isset($item['fragment']) ? '#' . $item['fragment'] : '';
        return '<li id="'.$id.'"><a href="' . $escapeHtml($link . $fragment) . '">' . $escapeHtml($label) . '</a></li >';
    }
}
