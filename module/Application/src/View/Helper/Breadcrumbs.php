<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays breadcrumbs.
 */
class Breadcrumbs extends AbstractHelper
{

    /**
     * Array of items.
     * @var array
     */
    private $items = [];

    /**
     * Array of items.
     * @var array
     */
    private $layout = 'default';

    /**
     * Constructor.
     * @param array $items Array of items (optional).
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Sets the items.
     * @param array $items Items.
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Renders the breadcrumbs.
     * @return string HTML code of the breadcrumbs.
     */
    public function render()
    {
        if (count($this->items) == 0) {
            return '';
        } // Do nothing if there are no items.

            
        // Resulting HTML code will be stored in this var
        $result = '<ol class="breadcrumb '.($this->layout != 'default'? 'bg-dark':'').'">';

        // Get item count
        $itemCount = count($this->items);

        $itemNum = 1; // item counter
        // Walk through items
        foreach ($this->items as $label => $link) {

            // Make the last item inactive
            $isActive = ($itemNum == $itemCount ? true : false);

            // Render current item
            $result .= $this->renderItem($label, $link, $isActive);

            // Increment item counter
            $itemNum++;
        }

        $result .= '</ol>';

        return $result;
    }

    /**
     * Renders an item.
     * @param string $label
     * @param string $link
     * @param boolean $isActive
     * @return string HTML code of the item.
     */
    protected function renderItem($label, $link, $isActive)
    {
        $escapeHtml = $this->getView()->plugin('escapeHtml');

        $result = $isActive ? '<li class="breadcrumb-item active">' : '<li class="breadcrumb-item">';

        if (!$isActive) {
            $result .= '<a class="text-secondary" href="' . $escapeHtml($link) . '">' . $escapeHtml($label) . '</a>';
        } else {
            $result .= '<span class="text-white">' . $escapeHtml($label) . '</span>';
        }

        $result .= '</li>';

        return $result;
    }

    /**
     * Sets breadcrumbs layout.
     * @param string $layOut
     * @return void
     */
    public function setLayout($layout = 'default')
    {
        $this->layout = $layout;
    }
}
