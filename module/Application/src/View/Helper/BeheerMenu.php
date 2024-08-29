<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplateMapResolver;
use Symfony\Component\VarDumper\VarDumper;

/**
 * This view helper class displays a menu bar.
 */
class BeheerMenu extends AbstractHelper
{
    /** @var array */
    protected array $items = [];
    /** @var string */
    protected string $layout;
    protected string $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct(array $items = [], string $layout = '')
    {
        $this->layout = $layout;
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

    public function render()
    {
        if (count($this->items) === 0) {
            $this->items = [];
        }

        $view = new ViewModel();
        $view->setVariables(['items' => $this->items]);
        $view->setTemplate('beheer');
        $resolver = new TemplateMapResolver([
            'beheer' => 'module/Application/view/menu/beheer.phtml',
        ]);

        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);

        //Render de view
        $content = $renderer->render($view);

        return $content;
    }
}
