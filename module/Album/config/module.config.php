<?php

use Album\Factory\DbValidatorAbstractFactory;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Db\RecordExists;

return [
    'db' => [
        'driver'         => 'Pdo',
        'dsn'            => 'sqlite:' . __DIR__ . '/../data/album.db',
    ],
    'controllers' => [
        'factories' => [
            'Album\Controller\Album' => 'Album\Controller\AlbumControllerFactory',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'album' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'validators' => [
        'factories' => [
            RecordExists::class => DbValidatorAbstractFactory::class,
            NoRecordExists::class => DbValidatorAbstractFactory::class,
        ]
    ],
    'input_filter_specs' => [
        'album.add' => [
            [
                'name'     => 'id',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int'],
                ],
            ],
            [
                'name'     => 'artist',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'title',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ],
                    ],
                    [
                        'name' => NoRecordExists::class,
                        'options' => [
                            'adapter' => Zend\Db\Adapter\Adapter::class,
                            'table' => 'album',
                            'field' => 'title'
                        ]
                    ]
                ],
            ]
        ]
    ]
];