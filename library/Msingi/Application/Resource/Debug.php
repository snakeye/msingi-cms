<?php

/**
 *
 */
class Msingi_Application_Resource_Debug extends Zend_Application_Resource_ResourceAbstract
{

	protected $_debug = null;

	/**
	 * Set debug variable and constant
	 */
	public function init()
	{
		if ($this->_debug == null)
		{
			// get options
			$options = $this->getOptions();

			$this->_debug = $options['enabled'] ? true : false;

			if (!defined('DEBUG'))
				define('DEBUG', $this->_debug);
		}

		return $this->_debug;
	}

}