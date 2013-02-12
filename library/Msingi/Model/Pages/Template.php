<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Model_Pages_Template extends Msingi_Db_Table_Row
{

	/**
	 *
	 * @return array of sections
	 */
	public function sections()
	{
		$sections = array();
		foreach (explode(',', $this->sections) as $section)
		{
			$sections[] = trim($section);
		}

		return $sections;
	}

}