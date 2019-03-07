<?php

namespace Album\Controller;
use Album\Model\AlbumTable;
use Interop\Container\ContainerInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class AlbumControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new AlbumController(
            $container->get(AlbumTable::class),
            $container->get(InputFilterPluginManager::class)->get('album.add')
        );

        return $controller;
    }
}