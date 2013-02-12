<?php

/**
 * Filter page tags
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Form_Filter_PageTags implements Zend_Filter_Interface
{

	protected $_allowed_tags;

	/**
	 *
	 */
	public function __construct()
	{
		$this->_allowed_tags = $this->getAllowedTags();
	}

	/**
	 * Get array of allowed tags
	 *
	 * @return array of allowed tags
	 */
	public function getAllowedTags()
	{
		return array(
			'div' => array('class'),
			'p' => array('class', 'style'),
			'img' => array('src', 'alt', 'title', 'width', 'height', 'style'),
			'a' => array('href', 'target', 'name', 'class', 'id'),
			'table' => array('width', 'border', 'cellspacing', 'cellpadding', 'class'),
			'tr' => array('colspan', 'rowspan', 'class'),
			'td' => array('colspan', 'rowspan', 'class'),
			'span' => array('class'),
			'i' => array(),
			'b' => array(),
			'u' => array(),
			'strong' => array(),
			'em' => array(),
			'br' => array(),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'table' => array(),
			'ul' => array('class'),
			'ol' => array('class'),
			'li' => array()
		);
	}

	/**
	 * Filters not allowed tags and attributes
	 *
	 * @see Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter($text)
	{
		// filter tags
		$tags = '<' . implode('><', array_keys($this->_allowed_tags)) . '>';
		$text = strip_tags($text, $tags);

		// filter attributes
		$sa = new Msingi_Util_StripAttributes();
		$sa->exceptions = $this->_allowed_tags;
		$text = $sa->strip($text);

		return $text;
	}

}