<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Rest\Controller\IndexController' => 'Rest\Controller\IndexController',
            'Rest\Controller\PlaceController' => 'Rest\Controller\PlaceController'
            
        ),
    ),
    'router' => array(
        'routes' => array(
            'SanRestful' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/molina-restfull',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Rest\Controller',
                        'controller'    => 'IndexController',
                    ),
                ),
                 
                'may_terminate' => true,
                'child_routes' => array(
                    'client' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/client[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'SampleClient',
                                'action'     => 'index'
                            ),
                        ),
                    ),
                ),
            ),
            'Place' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/molina-place',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Rest\Controller',
                        'controller'    => 'PlaceController',
                    ),
                ),
                 
                'may_terminate' => true,
                'child_routes' => array(
                    'client' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/client[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'SampleClient',
                                'action'     => 'index'
                            ),
                        ),
                    ),
                ),
            ),
                 'mama' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/getListPlace',
                    'defaults' => array(
                        'controller' => 'Rest\Controller\Index',
                        'action' => 'getListPlace'
                    )
                ),
            ),
        ),
    ),
);