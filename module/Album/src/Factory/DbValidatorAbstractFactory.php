<?php


namespace Album\Factory;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DbValidatorAbstractFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (isset($options['adapter']) && is_string($options['adapter'])) {
            $options['adapter'] = $container->get($options['adapter']);
        }

        return new $requestedName($options);
    }
}
