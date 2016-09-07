<?php

namespace Application\View\Helper;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 * Class RouteMatchFactory
 * @package Application\View\Helper
 */
class RouteMatchFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $match = $container->get('Application')
            ->getMvcEvent()
            ->getRouteMatch();

        return new RouteMatch($match);
    }
}