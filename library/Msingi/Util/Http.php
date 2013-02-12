<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Util_Http
{

	/**
	 *
	 * @param type $url
	 * @return type
	 */
	public static function build_url($url)
	{
		$ret = '';
		if (isset($url['scheme']))
		{
			// @todo Probably use current http scheme?
			$ret .= $url['scheme'] . ':';
		}

		if (isset($url['host']))
		{
			$ret .= '//' . $url['host'];
		}

		if (isset($url['path']))
		{
			$ret .= $url['path'];
		}

		return $ret;
	}

}