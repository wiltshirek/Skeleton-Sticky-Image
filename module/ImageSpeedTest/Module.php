<?php
namespace ImageSpeedTest;

use Zend\Db\ResultSet\ResultSet;
use ImageSpeedTest\Model\ImageSpeedTest;
use ImageSpeedTest\Model\ImageSpeedTestTable;
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
        	'invokables' => array( 
        		'ImageSpeedTest\Validator\ValidateUrl' => 'ImageSpeedTest\Validator\ValidateUrl'
        	),
            'factories' => array(
                'ImageSpeedTest\Model\ImageSpeedTestTable' =>  function($sm) {
                    $tableGateway = $sm->get('ImageSpeedTestTableGateway');
                    $table = new ImageSpeedTestTable($tableGateway);
                    return $table;
                },
                'ImageSpeedTestTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ImageSpeedTest());
                    return new TableGateway('imagespeedtest', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
