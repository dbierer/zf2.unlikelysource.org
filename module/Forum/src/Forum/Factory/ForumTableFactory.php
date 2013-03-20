<?php
namespace Forum\Factory;

use Forum\Model\ForumTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ForumTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
    	// see /path/to/onlinemarket/config/autoload/db.local.php
        $adapter   = $services->get('general-adapter');
        return new ForumTable(ForumTable::$tableName, $adapter);
    }
}
