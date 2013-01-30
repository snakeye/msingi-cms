<?php

class Msingi_Controller_Request extends Zend_Controller_Request_Http
{

	protected $_site;
	protected $_siteKey = 'site';
	protected $_section;
	protected $_sectionKey = 'section';

	/**
	 *
	 * @param $section
	 * @return \Msingi_Controller_Request
	 */
	public function setSection($section)
	{
		$this->_section = $section->name();

		$uri = parse_url($this->getRequestUri());

		// remove starting parts of the path
		$root_path = explode('/', trim(parse_url($section->root(), PHP_URL_PATH), '/'));
		$path = explode('/', trim($uri['path'], '/'));
		while (count($path) > 0 && count($root_path) > 0 && $root_path[0] == $path[0])
		{
			array_splice($path, 0, 1);
			array_splice($root_path, 0, 1);
		}

		// construct new uri
		$new_uri = '/' . implode('/', $path);
		if (isset($uri['query']))
			$new_uri .= '?' . $uri['query'];

		$this->setRequestUri($new_uri);

		return $this;
	}

	/**
	 *
	 * @return type
	 */
	public function getSectionName()
	{
		if (null === $this->_section)
		{
			$this->_section = $this->getParam($this->getSectionKey());
		}

		return $this->_section;
	}

	/**
	 *
	 * @return type
	 */
	public function getSectionKey()
	{
		return $this->_sectionKey;
	}

}