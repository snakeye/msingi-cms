<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Application_Sections
{

	protected $_sections;
	protected $_current_section;

	/**
	 *
	 * @param array $options
	 */
	public function init($options = array())
	{
		//
		$this->_sections = array();

		// create default sections
		$this->_sections['frontend'] = new Msingi_Application_Section('frontend', $options['frontend']);
		$this->_sections['backend'] = new Msingi_Application_Section('backend', $options['backend']);

		// collect other defined sections
		//$sections = explode(',', $options);
		foreach (array_keys($options) as $section)
		{
			$section = trim($section);
			if (!isset($this->_sections[$section]))
				$this->_sections[$section] = new Msingi_Application_Section($section, $options[$section]);
		}
	}

	/**
	 *
	 * @return type
	 */
	public function sections()
	{
		return $this->_sections;
	}

	/**
	 *
	 * @param type $name
	 * @return type
	 */
	public function getSection($name)
	{
		return $this->_sections[$name];
	}

	/**
	 *
	 * @return array
	 * @throws Zend_Exception
	 */
	public function getCurrentSection()
	{
		if ($this->_current_section == null)
		{
			// compose request
			$request = rtrim($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '/');

			// array of url to check against
			$check = array();

			// try sections
			foreach ($this->_sections as $section)
			{
				// array of urls to check against
				$check[$this->clean($section->root())] = $section;

				// we have multiple aliases
				foreach ($section->aliases() as $alias)
				{
					$check[$this->clean($alias)] = $section;
				}
			}

			// sort urls by length
			uksort($check, array($this, 'cmp'));

			//
			$lr = strlen($request);
			foreach ($check as $url => $section)
			{
				$lu = strlen($url);

				// check request against current url
				if ($lr >= $lu && substr($request, 0, $lu) == $url)
				{
					$this->_current_section = $section;
					break;
				}
			}

			//
			if ($this->_current_section == null)
			{
				throw new Zend_Exception(sprintf('Unable to determine site section for request %s', $request));
			}
		}

		return $this->_current_section;
	}

	/**
	 * @param string $url
	 * @return string
	 */
	protected function clean($url)
	{
		return parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
	}

	/**
	 * Compare two URLs by length
	 *
	 * @param string $a
	 * @param string $b
	 * @return int
	 */
	protected function cmp($a, $b)
	{
		$la = strlen($a);
		$lb = strlen($b);

		if ($la > $lb)
			return -1;

		if ($la < $lb)
			return 1;

		return 0;
	}

}