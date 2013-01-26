<?php

class Msingi_Theme
{

	protected $_name;

	/**
	 *
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->_name = $name;
	}

	/**
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->_name;
	}

}