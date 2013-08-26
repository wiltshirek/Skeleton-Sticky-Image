<?php

/**
 * Description of Module
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
//  module/Stickynotes/Module.php

namespace Stickynotes;

class Module {

    public function getAutoloaderConfig() {
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

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

  // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Stickynotes\Model\SticknotesTable' =>  function($sm) {
                    $tableGateway = $sm->get('SticknotesTableGateway');
                    $table = new SticknotesTable($tableGateway);
                    return $table;
                },
                'SticknotesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Sticknotes());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
    

}
