<?php

class Msingi_Application_Resource_Sections extends Zend_Application_Resource_ResourceAbstract
{

	protected $_sections;
	protected $_bootstrap;

	/**
	 *
	 */
	public function init()
	{
		return $this->getSections();
	}

	/**
	 *
	 * @return Msingi_Application_Sections
	 */
	public function getSections()
	{
		// create Msingi_Site object if need
		if ($this->_sections == null)
		{
			// get options
			$options = $this->getOptions();

			//
			$sections = new Msingi_Application_Sections();
			$sections->init($options);

			//
			$this->_sections = $sections;

			// store in registry
			Zend_Registry::set('Sections', $sections);

			// bootstrap current section
			$this->bootstrapSection($sections->getCurrentSection());

			// 
			Zend_Registry::set('CurrentSection', $sections->getCurrentSection());
		}

		return $this->_sections;
	}

	/**
	 *
	 * @param type $section
	 */
	protected function bootstrapSection($section)
	{
		$bootstrap = $this->getBootstrap();
		$bootstrap->bootstrap('FrontController');

		$front = $bootstrap->getResource('FrontController');

		$bootstrapClass = $this->_formatSectionName($section->name()) . '_Bootstrap';
		if (!class_exists($bootstrapClass, false))
		{
			$bootstrapPath = realpath(APPLICATION_PATH . '/sections/' . $section->name() . '/Bootstrap.php');
			if (file_exists($bootstrapPath))
			{
				include_once $bootstrapPath;
				if (!class_exists($bootstrapClass, false))
				{
					throw new Zend_Application_Resource_Exception(sprintf(
							$eMsgTpl, $module, $bootstrapClass
					));
				}

				$sectionBootstrap = new $bootstrapClass($bootstrap);
				$sectionBootstrap->bootstrap();

				$this->_bootstrap = $sectionBootstrap;
			}
		}

		//
		$front->addModuleDirectory(APPLICATION_PATH . '/sections/' . $section->name() . '/modules');

		// add sections's library to include path
		set_include_path(
			implode(PATH_SEPARATOR, array(get_include_path(),
				realpath(APPLICATION_PATH . '/sections/' . $section->name() . '/library')
				)
			)
		);
	}

	/**
	 *
	 * @param type $name
	 * @return type
	 */
	protected function _formatSectionName($name)
	{
		$name = strtolower($name);
		$name = str_replace(array('-', '.'), ' ', $name);
		$name = ucwords($name);
		$name = str_replace(' ', '', $name);
		return $name;
	}

}