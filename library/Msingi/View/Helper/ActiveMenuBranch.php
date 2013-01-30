<?php

class Msingi_View_Helper_ActiveMenuBranch extends Zend_View_Helper_Abstract
{

	/**
	 *
	 * @param Zend_Navigation $navigation
	 * @return Zend_Navigation
	 */
	public function activeMenuBranch($navigation)
	{
		$container = $navigation->getContainer();

		$iterator = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($iterator as $page)
		{
			if ($page->isActive(false))
			{
				$found = $page;
				$foundDepth = $iterator->getDepth();
			}
		}

		while (($foundDepth--) > 0)
		{
			$found = $found->getParent();
		}

		return $found;
	}

}