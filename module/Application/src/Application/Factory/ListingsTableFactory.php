<?php
namespace Application\Factory;

use Application\Model\ListingsTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class ListingsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
    	// see /path/to/onlinemarket/config/autoload/db.local.php
        $adapter   = $services->get('general-adapter');
        return new ListingsTable(ListingsTable::$tableName, $adapter);
    }
}
