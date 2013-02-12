<?php

/**
 * LessCSS compiler
 *
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_View_Helper_HeadLess extends Zend_View_Helper_Placeholder_Container_Standalone
{

	// URL of LessCSS compiler
	private $_less_js = '//lesscss.googlecode.com/files/less-1.3.0.min.js';

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
	 * headLess() - View Helper method
	 */
	public function headLess()
	{
		return $this;
	}

	/**
	 * Set URL of LessCSS compiler script
	 *
	 * @param string $value less.js URL
	 */
	public function setCompilerURL($value)
	{
		$this->_less_js = $value;
	}

	/**
	 * Append stylesheet URL
	 *
	 * @param string $url stylesheet URL
	 */
	public function appendStylesheet($url, $inline = true)
	{
		$value = (object) array(
					'url' => $url,
					'inline' => $inline,
		);

		return $this->getContainer()->append($value);
	}

	/**
	 * Render HTML elements
	 *
	 * @param integer $indent intent
	 * @return string
	 */
	public function toString($indent = null)
	{
		$indent = (null !== $indent) ? $this->getWhitespace($indent) : $this->getIndent();

		$items = array();
		$this->getContainer()->ksort();
		foreach ($this as $item)
		{
			$items[] = $this->itemToString($item);
		}

		// add less.js file
		if (APPLICATION_ENV == 'development' && $this->_less_js != '')
		{
			$items[] = '<script type="text/javascript">less={env:"development"};</script>';
			$items[] = '<script type="text/javascript" src="' . $this->_less_js . '"></script>';
		}

		return $indent . implode($this->_escape($this->getSeparator()) . $indent, $items);
	}

	/**
	 * Render html element
	 *
	 * @param mixed $item item to render
	 * @return string
	 */
	public function itemToString($item)
	{
		$url = str_replace('.less', '', $item->url);

		// change .less to .css for production environment
		if (APPLICATION_ENV == 'development')
		{
			$ext = 'less';
			$url .= '.' . $ext . '?r=' . time();
		}
		else
		{
			$ext = 'css';
			$url .= '.' . $ext;
		}

//		$file = parse_url($url, PHP_URL_PATH);
//		$ext = pathinfo($file, PATHINFO_EXTENSION);
//
//		if ($ext == 'css' && $config->minify->inlineCSS && $item->inline)
//		{
//			$relative = str_replace($urls->static, '', $url);
//
//			// is it local file?
//			if (is_file(STATIC_PATH . $relative))
//			{
//				// load css
//				$css = file_get_contents(STATIC_PATH . $relative);
//
//				// fix url paths
//				if (preg_match_all('/url\s*\(\s*[\'"]?([a-zA-Z0-9\/.-_]*)[\'"]?\s*\)/', $css, $matches))
//				{
//					for ($m = 0; $m < count($matches[0]); $m++)
//					{
//						// construct path to file
//						$path = pathinfo(STATIC_PATH . $relative, PATHINFO_DIRNAME) . '/' . $matches[1][$m];
//						// remove any relative parts
//						$path = $this->relativePath($path);
//						// construct url
//						$path = str_replace(STATIC_PATH, $urls->static, $path);
//						// replace in css
//						$css = str_replace($matches[0][$m], 'url(' . $path . ')', $css);
//					}
//				}
//
//				// @todo we could minify css here
//				// inline css
//				return '<style type="text/css">' . $css . '</style>';
//			}
//		}
//		else
		if ($ext == 'less')
		{
			return '<link href="' . $url . '" rel="stylesheet/less" type="text/css">';
		}

		return '<link href="' . $url . '" rel="stylesheet" type="text/css">';
	}

	/**
	 * Remove relative parts from the path
	 *
	 * @param string $path
	 * @param string $ps
	 */
	function relativePath($path, $ps = DIRECTORY_SEPARATOR)
	{
		$ret = array();
		$p = explode($ps, trim($path, $ps));

		foreach ($p as $dir)
		{
			if ($dir == '..')
			{
				array_pop($ret);
			}
			else
			{
				$ret[] = $dir;
			}
		}

		return $ps . implode($ps, $ret);
	}

}