<?php

class Msingi_Application_Section_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected $_sectionName;

	/**
	 *
	 * @param type $application
	 */
	public function __construct($application)
	{
		$this->setApplication($application);

		// Use same plugin loader as parent bootstrap
		if ($application instanceof Zend_Application_Bootstrap_ResourceBootstrapper)
		{
			$this->setPluginLoader($application->getPluginLoader());
		}

		$key = strtolower($this->getSectionName());
		if ($application->hasOption($key))
		{
			// Don't run via setOptions() to prevent duplicate initialization
			$this->setOptions($application->getOption($key));
		}

		if ($application->hasOption('resourceloader'))
		{
			$this->setOptions(array(
				'resourceloader' => $application->getOption('resourceloader')
			));
		}

		$this->initResourceLoader();

		// ZF-6545: ensure front controller resource is loaded
		if (!$this->hasPluginResource('FrontController'))
		{
			$this->registerPluginResource('FrontController');
		}

		// ZF-6545: prevent recursive registration of modules
		if ($this->hasPluginResource('sections'))
		{
			$this->unregisterPluginResource('sections');
		}
	}

	/**
	 *
	 */
	public function initResourceLoader()
	{
		$this->getResourceLoader();
	}

	/**
	 *
	 * @return type
	 */
	public function getSectionName()
	{
		if (empty($this->_sectionName))
		{
			$class = get_class($this);
			if (preg_match('/^([a-z][a-z0-9]*)_/i', $class, $matches))
			{
				$prefix = $matches[1];
			}
			else
			{
				$prefix = $class;
			}

			$this->_sectionName = strtolower($prefix);
		}
		return $this->_sectionName;
	}

}