<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 10:54
 */

namespace Blog;

use Blog\Factory\ZendDbSqlRepositoryFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;



return [
    'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class
        ]
    ],

    'router' => [
        'routes' => [
            'blog' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/blog',
                    /*'route' => '/blog[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        ],
                    */
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                        ],
                    ],
                    'may_terminate' => true,
                    'child_routes'  => [
                        'detail' => [
                            'type' => Segment::class,
                            'options' => [
                                'route'    => '/:id',
                                'defaults' => [
                                    'action' => 'detail',
                                ],
                                'constraints' => [
                                    'id' => '[1-9]\d*',
                                ],
                            ],
                        ],
                    ],
            ]
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
