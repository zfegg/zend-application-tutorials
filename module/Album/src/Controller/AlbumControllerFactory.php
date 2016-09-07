<?php

namespace Album\Controller;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AlbumControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new AlbumController();
        $controller->setAlbumTable($container->get('Album\Model\AlbumTable'));

        return $controller;
    }
}