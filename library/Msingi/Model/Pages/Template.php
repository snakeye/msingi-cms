<?php

/**
 * @package MsingiCms
 */
class Msingi_Model_Pages_Template extends Msingi_Db_Table_Row
{

	/**
	 *
	 * @return type
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