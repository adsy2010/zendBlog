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
            Model\PostCommandInterface::class => Model\ZendDbSqlCommand::class,
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\PostCommand::class => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
            Model\ZendDbSqlCommand::class => Factory\ZendDbSqlCommandFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::class,
            Controller\WriteController::class => Factory\WriteControllerFactory::class,
            Controller\DeleteController::class =>Factory\DeleteControllerFactory::class
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
                        'add' => [
                            'type' => Literal::class,
                            'options' => [
                                'route' => '/add',
                                'defaults' => [
                                    'controller' => Controller\WriteController::class,
                                    'action' => 'add'
                                ]
                            ]
                        ],
                        'edit' => [
                            'type' =>Segment::class,
                            'options' => [
                                'route' => '/edit/:id',
                                'defaults' => [
                                    'controller' => Controller\WriteController::class,
                                    'action' => 'edit'
                                ],
                                'constraints' => [
                                    'id' => '[0-9]\d*'
                                ]
                            ]
                        ],
                        'delete' => [
                            'type' => Segment::class,
                            'options' => [
                                'route' => '/delete/:id',
                                'defaults' => [
                                    'controller' => Controller\DeleteController::class,
                                    'action' => 'delete'
                                ],
                                'constraints' => [
                                    'id' => '[0-9]\d*'
                                ]
                            ]
                        ]
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
