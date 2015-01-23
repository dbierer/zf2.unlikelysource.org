<?php
namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
class CityCodesTable
{
    protected $tableName = 'world_city_area_codes';
    protected $tableGateway;
    protected $adapter;
    
	/**
	 * @return the $adapter
	 */
	public function getAdapter() {
		return $this->adapter;
	}

	/**
	 * @param field_type $adapter
	 */
	public function setAdapter($adapter) {
		$this->adapter = $adapter;
	}

	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/**
	 * @return the $tableGateway
	 */
	public function getTableGateway() {
		return $this->tableGateway;
	}

	/**
	 * @param Zend\Db\Adapter\Adapter $adapter
	 */
	public function setTableGateway() {
	    $this->tableGateway = new TableGateway($this->getTableName(),
	                                           $this->getAdapter());
	}

	/**
	 * @param string $country
	 * @return array [primary key] => city, country
	 */
	public function getListOfCitiesAndCountries($country = NULL)
	{
	    if ($country) {
    	    $list = $this->getListByCountry($country);
	    } else {
	        $list = $this->getTableGateway()->select();
	    }
	    // format in the form of an array 
	    $output = array();
	    foreach ($list as $row) {
	        $output[$row->world_city_area_code_id] = $row->city . ', ' . $row->ISO2;
	    }
	    return $output;
	}

    public function getListByFirstCountry()
    {
        $select = new Select();
        $select->from($this->getTableName())
                ->columns(array('ISO2'))
                ->order('ISO2 ASC')
                ->limit(1);
        $firstItem = $this->getTableGateway()->selectWith($select)->current();
        $list = $this->getListByCountry($firstItem->ISO2);
        $output = array();
        foreach ($list as $row) {
            $output[$row->id] = $row->city;
        }        
        return $output;
    }
     /**
	 * Returns a list of cities in ascending order by country
	 * @param string $country
	 * @return Zend\Db\ResultSet\ResultSet
	 */
	public function getListByCountry($country)
	{
	    $where = new Where();
	    $where->equalTo('ISO2', $country);
	    $select = new Select();
	    $select->from($this->getTableName())
	           ->columns(array('id' => 'world_city_area_code_id', 'city', 'state_province', 'area_code'))
	           ->where($where)
	           ->order('city ASC');
	    return $this->getTableGateway()->selectWith($select);
	}
	
	public function getInitListByCountry($code)
	{
	    $list = $this->getListByCountry($code);
	    $result = array();
	    foreach ($list as $row) {
	        $result[$row->id] = $row->city;
	    }
	    return $result;
	}
	/**
	 * @return array country
	 */
	public function getCountriesAndCities()
	{
	    $select = new Select();
	    $select->from($this->getTableName())
	           ->columns(array('ISO2'))
	           ->group('ISO2');
	    $list = $this->getTableGateway()->selectWith($select);
	    $output = array();
	    foreach ($list as $row) {
	        $output[$row->ISO2] = $this->getListByCountry($row->ISO2);
	    }
	    return $output;
	}
	/**
	 * @return array country
	 */
	public function getCountries()
	{
	    $select = new Select();
	    $select->from($this->getTableName())
	           ->columns(array('ISO2'))
	           ->group('ISO2');
	    $list = $this->getTableGateway()->selectWith($select);
	    $output = array();
	    foreach ($list as $row) {
	        $output[$row->ISO2] = $row->ISO2;
	    }
	    return $output;
	}
	/**
	 * 
	 * @param string $cityName
	 */
	public function getCityLike($cityName)
	{
	    $where  = new Where();
	    $where->like('city', $cityName . '%');
	    $select = new Select();
	    $select->from($this->getTableName())
        	   ->columns(array('world_city_area_code_id', 'city', 'state_province', 'ISO2'))
        	   ->where($where);
	    // format in the form of an array 
	    $list = $this->getTableGateway()->selectWith($select);
	    $output = array();
	    foreach ($list as $row) {
	        $output[] = $row->city . ' ' . $row->state_province . ' ' . $row->ISO2;
	    }
	    return $output;
	}
	
	/**
	 * 
	 * @param int $id
	 * @return 1 database record
	 */
	public function getCityById($id)
	{
	    return $this->getTableGateway()->select(array('world_city_area_code_id' => $id))->current();
	}
}