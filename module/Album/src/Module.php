<?php
namespace Album;

use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

//选用 Composer 自动加载功能， Zend\Loader 在此不需要
//    public function getAutoloaderConfig()
//    {
//        return array(
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//            ),
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                AlbumTable::class =>  function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}