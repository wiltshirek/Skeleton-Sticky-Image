<?php
namespace Casefile;

return array(
    'controllers' => array(
        'invokables' => array(
            'Casefile\Controller\Casefile' => 'Casefile\Controller\CasefileController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'casefile' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/casefile[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Casefile\Controller\Casefile',
                        'action'     => 'index',
                    ),
                ), 
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'casefile' => __DIR__ . '/../view',
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