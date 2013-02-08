<?php

class Form_Filter_PageTags extends Msingi_Form_Filter_PageTags
{

	public function getAllowedTags()
	{
		//$this->_allowed_tags = '<p><a><b><i><u><strong><em><br><h1><h2><h3><h4><h5><h6><table><tr><td><th><ul><ol><li><dt><dd><dl><img><hr><span><sub><sup>';
		return array(
			'p' => array('class'),
			'img' => array('src', 'alt', 'title', 'width', 'height'),
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

}