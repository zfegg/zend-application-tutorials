<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Router\RouteMatch as ZendRouteMatch;

/**
 * Class RouteMatch
 * @package Application\View\Helper
 */
class RouteMatch extends AbstractHelper
{
    protected $routeMatch;

    public function __construct(ZendRouteMatch $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
        return $this->routeMatch;
    }
}