<?php
namespace ClassFile\Model;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class ClassFileTable extends TableGateway
{
	public static $tableName = 'classfile';
	public $classfileId = 'classfile_id';	
	/**
	 * Inserts posting
	 * @param Array $data = uses form fields
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function add($data)
	{
		unset($data['captcha'], $data['submit']);
		return $this->insert($data);
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
		return $this->update($insertData, array($this->classfileId => $id));
	}
	
	// SELECT * FROM `classfile` WHERE `classfile_id` IN (SELECT MAX(`classfile_id`) FROM `classfile`)
	public function getLatestListing()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteId = $platform->quoteIdentifier($this->classfileId);
		$select = new Select();
		$select->from(self::$tableName);
		$expression = new Expression(sprintf('MAX(%s)', $quoteId));
		$subSelect = new Select();
		$subSelect->from(self::$tableName)->columns(array($expression));
		$where = new Where();
		$where->in($this->classfileId, $subSelect);
		$select->where($where);
		//echo $select->getSqlString($platform);
		return $this->selectWith($select)->current();
	}

	// SELECT * FROM `classfile` WHERE `class` = ?
	public function getListingsByClass($class = NULL)
	{
		return $this->select(array('class' => $class));	
	}

	// SELECT * FROM `listings` WHERE `listings_id` = ? LIMIT 1
	public function getListingById($id = 1)
	{
		return $this->select(array('listings_id' => $id))->current();	
	}

	// SELECT DISTINCT `class` FROM `classfile`
	public function getDistinctClasses()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteClass = $platform->quoteIdentifier('class');
		$expression = new Expression(sprintf('DISTINCT %s', $quoteClass));
		$select = new Select();
		$select->from(self::$tableName)->columns(array($expression));
		//echo $select->getSqlString($platform);
		return $this->selectWith($select);
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