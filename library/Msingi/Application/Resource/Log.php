<?php

class Msingi_Application_Resource_Log extends Zend_Application_Resource_ResourceAbstract
{

	protected $_enabled;
	protected $_log;

	/**
	 *
	 */
	public function init()
	{
		return $this->getLog();
	}

	/**
	 *
	 * @return type
	 */
	public function getLog()
	{
		if ($this->_enabled === null && $this->_log == null)
		{
			// get options
			$options = $this->getOptions();

			//
			$this->_enabled = $options['enabled'] ? true : false;

			//
			if ($this->_enabled && isset($options['file']))
			{
				//
				$writer = new Zend_Log_Writer_Stream($options['file']);

				// log format
				if (isset($options['format']))
				{
					$format = str_replace('\n', PHP_EOL, $options['format']);
				}
				else
				{
					$format = '%timestamp% %priorityName% (%priority%): %message% ' . PHP_EOL
						. '%info%' . PHP_EOL
						. PHP_EOL;
				}

				// set format
				$writer->setFormatter(new Zend_Log_Formatter_Simple($format));

				// create log with writer
				$log = new Zend_Log($writer);

				// store log object in registry
				Zend_Registry::set('Log', $log);

				// return as resource
				$this->_log = $log;
			}
		}

		return $this->_log;
	}

}