<?php

/**
 * Application settings
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Model_Settings extends Msingi_Db_Table
{

	// table name
	protected $_name = 'cms_settings';
	// default values
	protected $_defaults;

	/**
	 *
	 * @param type $name
	 * @return type
	 */
	protected function _getCacheId(array $params)
	{
		return 'Settings_' . md5(implode($params));
	}

	/**
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function get($name, $default = null)
	{
		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId(array($name));

		if (($value = $cache->load($cache_id)) === false)
		{
			$select = $this->select()->where('name = ?', $name);

			$row = $this->fetchRow($select);

			if ($row == null)
			{
				if ($this->_defaults != null && $this->_defaults->hasSetting($name))
				{
					$value = $this->_defaults->getDefault($name);
				}
				else
				{
					$value = $default;
				}
			}
			else
			{
				$value = $row->value;
			}

			$cache->save($value, $cache_id);
		}

		return $value;
	}

	/**
	 *
	 * @param string $name
	 * @return string
	 */
	public function getString($name, $default = '')
	{
		$value = $this->get($name, $default);

		return $value;
	}

	/**
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function getBoolean($name, $default = false)
	{
		$value = $this->get($name, $default);

		return intval($value) ? true : false;
	}

	/**
	 * @todo this method
	 *
	 * @param string $name
	 * @return array
	 */
	public function getArray($name, $default = array())
	{
		$value = @unserialize($this->get($name));

		if ($value === false)
			return $default;

		return $value;
	}

	/**
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set($name, $value)
	{
		// update cached value
		$cache = Zend_Registry::get('Zend_Cache');
		$cache_id = $this->_getCacheId(array($name));
		//$cache->save($value, $cache_id);
		$cache->remove($cache_id);

		//
		if (is_array($value))
		{
			$value = serialize($value);
		}

		//
		$select = $this->select()->where('name = ?', $name);

		$row = $this->fetchRow($select);
		if ($row == null)
		{
			$row = $this->createRow(array(
				'name' => $name,
					));
		}

		$row->value = $value;
		$row->save();
	}

	/**
	 *
	 */
	public function setDefaults($defaults)
	{
		$this->_defaults = $defaults;
	}

}