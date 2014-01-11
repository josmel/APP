<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    
    'router' => array(
        'routes' => array(
            'event' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Event\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'event' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Event\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ), 
            
           'yes' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/place',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Place',
                        'action' => 'index'
                    )
                ),
               ),
            'complaint' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/complaint',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Complaint',
                        'action' => 'index'
                    )
                ),
               ),
            'jsonLugares' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/json-lugares-molina',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Complaint',
                        'action' => 'jsonLugares'
                    )
                ),
               ),
        
            'jsonFecha' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/json-Event-Date',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Index',
                        'action' => 'jsonFecha'
                    )
                ),
               ),
              'AgregarEvent' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/agregar-event',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Index',
                        'action' => 'agregarEvent'
                    )
                ),
               ),
             'insertPictureEvent' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/agregar-picture',//[/:in_id]
                    'defaults' => array(
                        'controller' => 'Event\Controller\Index',
                        'action' => 'insertPictureEvent'
                    )
                ),
               ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
 'controllers' => array(
        'invokables' => array(
            'Event\Controller\Index' => 'Event\Controller\IndexController',
            'Event\Controller\Complaint' => 'Event\Controller\ComplaintController',
            'Event\Controller\Place' => 'Event\Controller\PlaceController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'event/index/index' => __DIR__ . '/../view/event/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
