<?php

use App\TwigExtension\TranslationExtension;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'factories'  => [
            TranslationExtension::class => ReflectionBasedAbstractFactory::class,
        ],
    ],
    'twig' => [
        'extensions' => [
            TranslationExtension::class,
        ],
    ],
];
