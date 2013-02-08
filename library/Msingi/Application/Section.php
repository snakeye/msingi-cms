<?php

class Msingi_Application_Section
{

	protected $_name;
	protected $_root;
	protected $_aliases;
	protected $_modules;
	protected $_assets;

	/**
	 *
	 * @param string $name
	 * @param array $options
	 */
	public function __construct($name, $options = array())
	{
		$this->_name = $name;

		// root location is required
		if (!isset($options['root']))
		{
			throw new Zend_Application_Bootstrap_Exception(sprintf('Root URL for section %s is not set', $name));
		}

		$this->_root = $options['root'];

		// aliases
		$this->_aliases = array();
		if (isset($options['aliases']))
		{
			$aliases = explode(',', $options['aliases']);
			if (count($aliases) > 1)
			{
				foreach ($aliases as $alias)
				{
					$alias = trim($alias);
					$this->_aliases[] = $alias;
				}
			}
			else if (count($urls) == 1)
			{
				$this->_aliases[] = trim($urls[0]);
			}
		}

		if (isset($options['assets']))
		{
			$this->_assets = $options['assets'];
		}
	}

	/**
	 *
	 * @return type
	 */
	public function name()
	{
		return $this->_name;
	}

	/**
	 *
	 * @return string
	 */
	public function root()
	{
		return $this->_root;
	}

	/**
	 *
	 * @return array
	 */
	public function aliases()
	{
		return $this->_aliases;
	}

	/**
	 *
	 * @return \Msingi_Themes_Theme
	 */
	public function assets()
	{
		return $this->_assets;
	}

	/**
	 *
	 * @param type $url
	 * @return string
	 */
	public function url($url)
	{
		$url = rtrim($this->_root, '/') . '/' . ltrim($url, '/');

		return $url;
	}

}