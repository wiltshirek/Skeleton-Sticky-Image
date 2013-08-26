<?php
namespace Stickynotes;

return array(
    'controllers' => array(
        'invokables' => array(
            'Stickynotes\Controller\Stickynotes' => 'Stickynotes\Controller\StickynotesController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'stickynotes' => array(
                'type'    => 'segment',
                'options' => array(
                    'route' => '/stickynotes[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Stickynotes\Controller\Stickynotes',
                        'action'     => 'index',
                    ),
                ), 
            ),
        ),
    ),

    'view_manager' => array(
    		'template_map' => array(
    				'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
    				
    		),
        'template_path_stack' => array(
            'stickynotes' => __DIR__ . '/../view',
        ),
    ),


    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )

);