<?php
namespace Forum\Model;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class ForumTable extends TableGateway
{
	public static $tableName = 'forum';
	public $primaryKey = 'forum_id';	
	
	/**
	 * Inserts posting
	 * @param Array $data = uses form fields
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function add($data)
	{
		if ($data) {
			unset($data['captcha'], $data['submit'], $data['selectCategory'], $data['selectTopic']);
			return $this->insert($data);
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Updates posting
	 * @param int $id
	 * @param Array $data = uses form fields
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function edit($id, $data)
	{
		unset($data['captcha'], $data['submit'], $data['selectCategory'], $data['selectTopic']);
		return $this->update($data, array('forum_id' => $id));
	}
	
	/**
	 * Deletes posting
	 * @param int $id
	 * @return boolean $result = TRUE if operation was successful
	 */
	public function remove($id)
	{
		return $this->delete(array('forum_id' => $id));
	}
	
	// SELECT * FROM `forum` WHERE `forum_id` IN (SELECT MAX(`forum_id`) FROM `forum`)
	public function getLatestTitle()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteId = $platform->quoteIdentifier($this->primaryKey);
		$select = new Select();
		$select->from(self::$tableName);
		$expression = new Expression(sprintf('MAX(%s)', $quoteId));
		$subSelect = new Select();
		$subSelect->from(self::$tableName)->columns(array($expression));
		$where = new Where();
		$where->in($this->primaryKey, $subSelect);
		$select->where($where);
		//echo $select->getSqlString($platform);
		return $this->selectWith($select)->current();
	}

	// SELECT * FROM `forum` WHERE `forum_id` = ?
	public function getListingById($forumId)
	{
		return $this->select(array('forum_id' => $forumId))->current();	
	}

	// SELECT * FROM `forum` WHERE `category` = ? AND `topic` = ?
	public function getListingsByCategoryAndTopic($category, $topic)
	{
		/*
		$select = new Select();
		$select->from(self::$tableName);
		$select->where(array('category' => $category));
		$select->where(array('topic' => $topic));
		return $this->selectWith($select);
		*/
		return $this->select(array('category' => $category, 'topic' => $topic));	
	}

	// SELECT * FROM `forum` WHERE `category` = ?
	public function getTopicsByCategory($category)
	{
		return $this->select(array('category' => $category));	
	}

	// SELECT DISTINCT `topic` FROM `forum`
	public function getDistinctTopicsByCategory($category)
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteIdentifier = $platform->quoteIdentifier('topic');
		$expression = new Expression(sprintf('DISTINCT %s', $quoteIdentifier));
		$select = new Select();
		$select->from(self::$tableName)->columns(array('item' => $expression));
		$select->where(array('category' => $category));
		//echo $select->getSqlString($platform);
		return $this->selectWith($select);
	}

	// SELECT DISTINCT `topic` FROM `forum`
	public function getDistinctTopics()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteIdentifier = $platform->quoteIdentifier('topic');
		$expression = new Expression(sprintf('DISTINCT %s', $quoteIdentifier));
		$select = new Select();
		$select->from(self::$tableName)->columns(array('item' => $expression));
		//echo $select->getSqlString($platform);
		return $this->selectWith($select);
	}

	// SELECT DISTINCT `category` FROM `forum`
	public function getDistinctCategories()
	{
		$adapter = $this->getAdapter();
		$platform = $adapter->getPlatform();
		$quoteIdentifier = $platform->quoteIdentifier('category');
		$expression = new Expression(sprintf('DISTINCT %s', $quoteIdentifier));
		$select = new Select();
		$select->from(self::$tableName)->columns(array('item' => $expression));
		//echo $select->getSqlString($platform);
		return $this->selectWith($select);
	}

}