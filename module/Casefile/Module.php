<?php
namespace Casefile;

use Zend\Db\ResultSet\ResultSet;
use Casefile\Model\Casefile;
use Casefile\Model\CasefileTable;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
     // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Casefile\Model\CasefileTable' =>  function($sm) {
                    $tableGateway = $sm->get('CasefileTableGateway');
                    $table = new CasefileTable($tableGateway);
                    return $table;
                },
                'CasefileTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Casefile());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
