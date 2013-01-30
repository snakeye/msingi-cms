<?php

class Msingi_Model_Constants_Timezones
{

	const LABEL_NAME = 'name';

	protected static $s_values;
	protected $_values;

	/**
	 *
	 */
	public function __construct()
	{
		$class = get_class($this);

		// do we have stored categories for this class?
		if (!isset(self::$s_values[$class]))
		{
			$this->_values = $this->_getValues();

			// store static values
			self::$s_values[$class] = $this->_values;
		}
		else
		{
			// get static values
			$this->_values = self::$s_values[$class];
		}
	}

	/**
	 *
	 * @return array
	 */
	protected function _getValues()
	{
		$timezones = array(
			'America/Chicago' => array('name' => 'America/Chicago'),
			'Europe/London' => array('name' => 'Europe/London'),
			'Europe/Moscow' => array('name' => 'Europe/Moscow'),
			'Europe/Prague' => array('name' => 'Europe/Prague'),
			'UTC' => array('name' => 'UTC'),
		);

		return $timezones;
	}

	/**
	 * Overrides base function with native names result
	 *
	 * @param type $with_empty
	 * @return type
	 */
	public function getPairs($with_empty = false,
		$label_field = Msingi_Model_Constants_Timezones::LABEL_NAME)
	{
		$pairs = array();

		if ($with_empty)
		{
			$pairs[null] = '';
		}

		foreach ($this->_values as $id => $cat)
		{
			switch ($label_field)
			{
				case Msingi_Model_Constants_Timezones::LABEL_NAME:
					$label = $cat['name'];
					break;
			}
			$pairs[$id] = $label;
		}

		return $pairs;
	}

	/**
	 *
	 * @param type $code
	 */
	public function getName($code)
	{
		return $this->_values[$code]['name'];
	}

	/**
	 *
	 * @return array
	 */
	public function getArray()
	{
		return $this->_values;
	}

}