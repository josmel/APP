<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $eventTable;

    public function indexAction() {
        return new ViewModel();
    }

    public function molinaAction() {
        $view = new ViewModel();
        header('Content-type: application/x-javascript');
        header("Status: 200");
        $categorias = $this->getEventTable()->eventos();
        $valoresBlog[] = array();
        for ($i = 0; $i < count($categorias); $i++) {
            $valoresBlog[$i]['idevent'] = $categorias[$i]['idevent'];
            $valoresBlog[$i]['name'] = $categorias[$i]['name'];
            $valoresBlog[$i]['description'] = $categorias[$i]['description'];
            $valoresBlog[$i]['location'] = $categorias[$i]['location'];
            $valoresBlog[$i]['dateEvent'] = $categorias[$i]['dateEvent'];
            $valoresBlog[$i]['picture'] = $categorias[$i]['picture'];
        }
        echo json_encode($valoresBlog);
        exit();
        $view->setTerminal(true);
        return $view;
    }

    public function getEventTable() {
        if (!$this->eventTable) {
            $sm = $this->getServiceLocator();
            $this->eventTable = $sm->get('Event\Model\EventTable');
        }
        return $this->eventTable;
    }

}
