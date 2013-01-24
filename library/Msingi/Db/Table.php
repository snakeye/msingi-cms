<?php

class Msingi_Db_Table extends Zend_Db_Table
{

	protected static $_instance = array();

	/**
	 *
	 * @return Msingi_Db_Table
	 */
	public static function getInstance()
	{
		$sClassName = get_called_class();

		if (!isset(self::$_instance[$sClassName]))
		{
			self::$_instance[$sClassName] = new $sClassName();
		}

		return self::$_instance[$sClassName];
	}

	/**
	 *
	 * @param integer $id null or -1 to create new object
	 * @param array $params create row parameters
	 * @return Msingi_Db_Table_Row|null
	 */
	public static function fetchOrCreate($id, array $params = array())
	{
		$table = new static;

		if ($id == -1 || $id == null)
		{
			$object = $table->createRow($params);
		}
		else
		{
			$object = $table->fetchById($id);
		}

		return $object;
	}

	/**
	 *
	 * @param type $id
	 * @return type
	 */
	public function fetchById($id, $use_cache = true)
	{
		if ($this->isCacheEnabled() && $use_cache)
		{
			$cache = Zend_Registry::get('Zend_Cache');
			$cache_id = $this->_getCacheId(array($id));

			if (($row = $cache->load($cache_id)) === false)
			{
				$select = $this->select()->where('id = ?', intval($id));
				$row = $this->fetchRow($select);

				if ($row != null)
					$cache->save($row, $cache_id);
			}
		}
		else
		{
			$select = $this->select()->where('id = ?', intval($id));
			$row = $this->fetchRow($select);
		}

		return $row;
	}

	/**
	 *
	 * @param type $select
	 */
	public function fetchAllById($select)
	{
		$ret = array();

		$rows = $this->fetchAll($select);

		foreach ($rows as $row_id)
		{
			$row = $this->fetchById($row_id->id);
			if ($row != null)
				$ret[] = $row;
		}

		return $ret;
	}

	/**
	 *
	 * @param type $select
	 */
	public function countRows($select)
	{
		$select->from($this, array('cnt' => 'COUNT(*)'));

		return $this->getAdapter()->fetchOne($select);
	}

	/**
	 *
	 * @return boolean
	 */
	protected function isCacheEnabled()
	{
		return false;
	}

	/**
	 *
	 * @param integer $id
	 * @return string
	 */
	protected function _getCacheId(array $params)
	{
		return $this->_name . '_object_' . implode('_', $params);
	}

	/**
	 * Static function for row creation
	 * @param type $data
	 * @return type
	 */
	public static function createRowStatic($data = array())
	{
		$table = new static;
		return $table->createRow($data);
	}

}