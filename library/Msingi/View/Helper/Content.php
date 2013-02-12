<?php

/**
 * View helper for creating content URLs
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_Content extends Zend_View_Helper_Abstract
{

	/**
	 * content() View Helper method
	 *
	 * @param string $file file path
	 * @param string $default subsitution if requested file not found
	 * @return string URL relative to Content
	 */
	public function content($file = '', $default = '')
	{
		if (!Zend_Registry::isRegistered('Content'))
			return '';

		$content = Zend_Registry::get('Content');

		// no file given, just content root
		if ($file == '')
			return $content->url;

		// check the file exists
		if (!is_file($content->dir . '/' . $file))
		{
			return $default;
		}

		//
		$url = parse_url($content->url . $file);

		//
		return Msingi_Util_Http::build_url($url);
	}

}