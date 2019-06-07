<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\HyperlinkController;
use Application\Controller\Factory\HyperlinkControllerFactory;
use Application\Form\HyperlinkForm;
use Application\Form\Factory\HyperlinkFormFactory;
use Application\Service\Factory\HyperlinkModelPrimaryAdapterFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'links' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/links',
                    'defaults' => [
                        'controller' => HyperlinkController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'priority' => -100,
                        'options' => [
                            'route' => '/[:action[/:uuid]]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => HyperlinkController::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            HyperlinkController::class => HyperlinkControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            HyperlinkForm::class => HyperlinkFormFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Links',
                'route' => 'links',
                'class' => 'dropdown',
                'pages' => [
                    [
                        'label' => 'Add New Link',
                        'route' => 'links/default',
                        'action' => 'create'
                    ],
                    [
                        'label' => 'Search Links',
                        'route' => 'links/default',
                        'action' => 'search',
                    ],
                    [
                        'label' => 'View Links',
                        'route' => 'links/default',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'hyperlink-model-primary-adapter-config' => 'model-primary-adapter-config',
        ],
        'factories' => [
            'hyperlink-model-primary-adapter' => HyperlinkModelPrimaryAdapterFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../../Midnet/view/layout/layout.phtml',
            'layout/metromega'        => __DIR__ . '/../view/layout/metromega.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
