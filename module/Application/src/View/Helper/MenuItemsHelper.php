<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Symfony\Component\VarDumper\VarDumper;
use function is_object;

// This view helper class translate text
class MenuItemsHelper extends AbstractHelper
{
    public function generateMenuItems($menuItems, $urlHelper, $childeren = 0)
    {
        if ($childeren == 0) {
            echo '<ol class="sortable">';
        } else {
            echo '<ol>';
        }
        foreach ($menuItems AS $item) {

            $parentCheck = $childeren === 0 && is_object($item->getParent());
            if ($parentCheck){continue;}

            echo '<li id="menuItem_' . $item->getId() . '">';
            echo '<div class="row bg-body">';
            echo '<span class="col text-primary"><i class="'.$item->getIcon().' me-2"></i> ' . $item->getLabel() . '</span>';
            echo '<span class="col-md-auto text-center">';
            echo '<a class="btn btn-sm btn-secondary" ';
            echo 'href="' . $urlHelper->url('beheer/menu', ['action' => 'editMenuItem', 'id' => $item->getId()]) . '">';
            echo '<i class="fas fa-edit"></i>';
            echo '</a>';
            echo '&nbsp;';
            echo '<a class="btn btn-sm btn-danger '.(count($item->getChildren()) > 0?"disabled":"").'" href="';
            echo $urlHelper->url('menuajax', ['action' => 'deleteMenuItem', 'id' => $item->getId()]) . '">';
            echo '<i class="fas fa-trash-alt"></i>';
            echo '</a>';
            echo '</div>';

            if (count($item->getChildren()??[] > 0)) {
                $this->generateMenuItems($item->getChildren(), $urlHelper, 1);
            }
            echo '</li>';
        }
        echo '</ol>';
    }
}