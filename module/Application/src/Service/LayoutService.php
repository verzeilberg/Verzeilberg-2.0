<?php

namespace Application\Service;

use Exception;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplateMapResolver;
use Symfony\Component\VarDumper\VarDumper;

class LayoutService
{

    private mixed $config;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Load a view with the given variables and layout.
     *
     * @param array $variables An array of variables to be passed to the view.
     * @param string $layout The layout of the view.
     *
     * @return string The rendered view as a string.
     *
     * @throws Exception If an error occurs while rendering the view.
     */
    public function loadView(string $layout, array $variables = [], ): string
    {

        try {
            $view = new ViewModel();
            $view->setVariables(['items' => $variables]);
            $view->setTemplate('template');
            $resolver = new TemplateMapResolver([
                'template' => 'module/Application/view/menu/' . $layout . '.phtml',
            ]);

            $renderer = new PhpRenderer();
            $renderer->setResolver($resolver);

            //Render de view
            return $renderer->render($view);
        } catch (Exception $e) {
            die('error');
            throw $e;
        }
    }
}
