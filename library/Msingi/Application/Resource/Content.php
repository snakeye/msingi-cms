<?php

class Msingi_Application_Resource_Content extends Zend_Application_Resource_ResourceAbstract
{

	protected $_content;

	/**
	 *
	 */
	public function init()
	{
		return $this->getContent();
	}

	/**
	 *
	 * @return type
	 */
	public function getContent()
	{
		if ($this->_content === null)
		{
			// get options
			$options = $this->getOptions();

			// return as resource
			$this->_content = (object) $options;

			Zend_Registry::set('Content', $this->_content);
		}

		return $this->_content;
	}

}