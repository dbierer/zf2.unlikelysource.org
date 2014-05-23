<?php
namespace Application\Model;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class ListingsTable extends TableGateway
{
	public static $tableName = 'listings';
	public $listingsId = 'listings_id';
	
	// key = form field; value = column name
	protected $formMappings = array(
			'category' 		=> 'category',
			'title' 		=> 'title',
			'price' 		=> 'price',
			'photo'			=> 'photo_filename',
			'expires' 		=> 'date_expires',
			'city' 			=> 'city',
			'country' 		=> 'country',
			'name' 			=> 'contact_name',
			'phone' 		=> 'contact_phone',
			'email' 		=> 'contact_email',
			'delCode' 		=> 'delete_code',
			'description' 	=> 'description'
	);	
	
	public function getTableName()
	{
	    return self::$tableName;
	}
	
	/**
	 * Inserts posting
	 * @param Array $data = uses form fields
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function add($data)
	{
		$insertData = array();
		foreach ($this->formMappings as $key => $value) {
			$insertData[$value] = $data[$key];
		}
		return $this->insert($insertData);
	}
	
	/**
	 * Updates posting
	 * @param int $id
	 * @param Array $data = uses form fields
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function edit($id, $data)
	{
		$insertData = array();
		foreach ($this->formMappings as $key => $value) {
			$insertData[$value] = $data[$key];
		}
		return $this->update($insertData, array($this->listingsId => $id));
	}
	
	// SELECT * FROM `listings` WHERE `listings_id` IN (SELECT MAX(`listings_id`) FROM `listings`)
	public function getLatestListing()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteId = $platform->quoteIdentifier($this->listingsId);
		$select = new Select();
		$select->from(self::$tableName);
		$expression = new Expression(sprintf('MAX(%s)', $quoteId));
		$subSelect = new Select();
		$subSelect->from(self::$tableName)->columns(array($expression));
		$where = new Where();
		$where->in($this->listingsId, $subSelect);
		$select->where($where);
		return $this->selectWith($select)->current();
	}

	// SELECT * FROM `listings` WHERE `category` = ?
	public function getListingsByCategory($category = NULL)
	{
		$select = new Select();
		$select->from(self::$tableName);
		$where = new Where();
		$where->equalTo('category', $category);
		$select->where($where);
		return $this->selectWith($select);	
	}

	// SELECT * FROM `listings` WHERE `listings_id` = ? LIMIT 1
	public function getListingById($id = 1)
	{
		$select = new Select();
		$select->from(self::$tableName);
		$where = new Where();
		$where->equalTo($this->listingsId, $id);
		$select->where($where);
		$select->limit(1);
		return $this->selectWith($select)->current();	
	}

	/**
	 * Retrieves listings from table with fields = form fields
	 * @param int $id
	 * @return array $formData
	 */
	public function getListingForForm($id)
	{
		$listing = $this->getListingById($id);
		$formData = array();
		if ($listing) {
			foreach ($this->formMappings as $key => $value) {
				$formData[$key] = $listing[$value];
			}
		}
		return $formData;
	}
}