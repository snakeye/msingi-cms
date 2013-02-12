<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Application_Resource_Dir extends Zend_Application_Resource_ResourceAbstract
{

	protected $_dir;

	/**
	 *
	 */
	public function init()
	{
		return $this->getDir();
	}

	/**
	 *
	 * @return type
	 */
	public function getDir()
	{
		if ($this->_dir == null)
		{
			// get options
			$options = $this->getOptions();

			// return as resource
			$this->_dir = (object) $options;

			Zend_Registry::set('Dir', $this->_dir);
		}

		return $this->_dir;
	}

}