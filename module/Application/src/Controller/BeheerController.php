<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class BeheerController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \viewhelpermanager
     */
    protected $vhm;
    protected $tos;

    public function __construct($entityManager, $viewHelperManager) {

        $this->em = $entityManager;
        $this->vhm = $viewHelperManager;
    }

    public function indexAction() {

        $this->layout('layout/beheer');
        $this->vhm->get('headScript')->appendFile('/beheerAssets/js/charts.js');
        $this->vhm->get('headScript')->appendFile('https://www.google.com/jsapi');

        return new ViewModel();
    }

}