<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Event\Model\Event;
use Event\Model\EventTable;
use Event\Model\Place;
use Event\Model\PlaceTable;
use Event\Model\Complaint;
use Event\Model\ComplaintTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Event\Model\EventTable' =>  function($sm) {
                    $tableGateway = $sm->get('EventTableGateway');
                    $table = new EventTable($tableGateway);
                    return $table;
                },
                'EventTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Event());
                    return new TableGateway('event', $dbAdapter, null, $resultSetPrototype);//
                },
                 'Event\Model\ComplaintTable' =>  function($sm) {
                    $tableGateway = $sm->get('ComplaintTableGateway');
                    $table = new ComplaintTable($tableGateway);
                    return $table;
                },
                'ComplaintTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Complaint());
                    return new TableGateway('complaint', $dbAdapter, null, $resultSetPrototype);//
                },
                'Event\Model\PlaceTable' =>  function($sm) {
                    $tableGateway = $sm->get('PlaceTableGateway');
                    $table = new PlaceTable($tableGateway);
                    return $table;
                },
                'PlaceTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Place());
                    return new TableGateway('place', $dbAdapter, null, $resultSetPrototype);//
                },
       
            ),
        );
    }
}
