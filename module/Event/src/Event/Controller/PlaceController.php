<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event\Controller;

use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use SanAuth\Controller\AuthController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PlaceController extends AbstractActionController
{
  protected $placeTable;
   protected $complaintTable;
    public function indexAction() {
        
      $categorias = $this->getPlaceTable()->placeFull();
           var_dump($categorias);exit;
        return new ViewModel();
    }
    
    
     public function getComplaintTable()
    {
        if (! $this->complaintTable) {
            $sm = $this->getServiceLocator();
            $this->complaintTable = $sm->get('Event\Model\ComplaintTable');
        }
        return $this->complaintTable;
    }
     public function getPlaceTable()
    {
        if (! $this->placeTable) {
            $sm = $this->getServiceLocator();
            $this->placeTable = $sm->get('Event\Model\PlaceTable');
        }
        return $this->placeTable;
    }
}
