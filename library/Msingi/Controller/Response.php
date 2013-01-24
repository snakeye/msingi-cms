<?php

class Msingi_Controller_Response extends Zend_Controller_Response_Http
{

	protected $_content_type;
	protected $_charset;
	protected $_cache_control;
	protected $_cache_lifetime;

	/**
	 *
	 * @param type $content_type
	 */
	public function setContentType($content_type)
	{
		$this->_content_type = $content_type;
	}

	/**
	 *
	 * @return type
	 */
	public function getContentType()
	{
		return $this->_content_type;
	}

	/**
	 *
	 * @param type $charset
	 */
	public function setCharset($charset = 'UTF-8')
	{
		$this->_charset = $charset;
	}

	/**
	 *
	 * @return type
	 */
	public function getCharset()
	{
		return $this->_charset;
	}

	/**
	 *
	 * @param type $enabled
	 */
	public function setCacheControl($enabled = true)
	{
		$this->_cache_control = $enabled;
	}

	/**
	 *
	 * @return type
	 */
	public function getCacheControl()
	{
		return $this->_cache_control;
	}

	/**
	 *
	 * @param type $lifetime
	 */
	public function setCacheLifetime($lifetime)
	{
		$this->_cache_lifetime = $lifetime;
	}

	/**
	 *
	 * @return type
	 */
	public function getCacheLifetime()
	{
		return $this->_cache_lifetime;
	}

}