<?php
namespace ClassFile\Factory;

use ClassFile\Model\ClassFileTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClassFileTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
    	// see /path/to/onlinemarket/config/autoload/db.local.php
        $adapter   = $services->get('general-adapter');
        return new ClassFileTable(ClassFileTable::$tableName, $adapter);
    }
}
