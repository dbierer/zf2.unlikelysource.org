<?php
namespace FormDemo\Service;

use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
class TableService
{
    protected $listingsTable;
    protected $cityCodesTable;
    public function getListingsTable()
    {
        return $this->listingsTable;
    }
    public function getCityCodesTable()
    {
        return $this->cityCodesTable;
    }
    public function setListingsTable($table)
    {
    	$this->listingsTable = $table;
    }
    public function setCityCodesTable($table)
    {
    	$this->cityCodesTable = $table;
    }
    /**
     * @return array country
     */
    public function getCountriesAndCitiesWithSums()
    {
        $adapter = $this->cityCodesTable->getTableGateway()->getAdapter();
        $sql   = new Sql($adapter);
        $select = $sql->select();
        $where = new Where();
        $where->isNotNull('l.price');
    	$select->from(array('c' => $this->cityCodesTable->getTableName()))
            	->columns(array('ISO2'))
            	->join(array('l' => $this->listingsTable->getTableName()),
            	       'c.ISO2 = l.country',
            	        array('total' => new Expression('SUM(price)')))
            	->where($where)
            	->group('c.ISO2');
        //echo $select->getSqlString($this->listingsTable->getAdapter()->getPlatform());
        //exit;
    	$list = $adapter->query($select->getSqlString($adapter->getPlatform()), 
    	                        Adapter::QUERY_MODE_EXECUTE);
    	$output = array();
    	foreach ($list as $row) {
    		$output[$row->ISO2] = array('sum' => $row->total,
    		                            'cities' => $this->cityCodesTable->getListByCountry($row->ISO2));
    	}
    	return $output;
    }

}