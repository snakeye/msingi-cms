<?php

/**
 * Collect jQuery snippets in single block
 * 
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_Jquery extends Zend_View_Helper_Placeholder_Container_Standalone
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_regKey = get_class($this);

		parent::__construct();

		$this->setSeparator(PHP_EOL);
	}

	/**
	 *
	 */
	public function jquery()
	{
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function toString($indent = null)
	{
		$indent = (null !== $indent) ? $this->getWhitespace($indent) : $this->getIndent();

		$items = array();
		$this->getContainer()->ksort();
		foreach ($this as $item)
		{
			$item = str_replace('<script>', '', $item);
			$item = str_replace('</script>', '', $item);
			$item = trim($item);

			if ($item != '')
			{
				$items[] = $item;
			}
		}

		if (count($items) > 0)
		{
			array_unshift($items, '	$(document).ready(function(){');
			array_unshift($items, '<script type="text/javascript">');

			array_push($items, '});');
			array_push($items, '</script>');

			return $indent . implode($this->_escape($this->getSeparator()) . $indent, $items);
		}

		return '';
	}

}