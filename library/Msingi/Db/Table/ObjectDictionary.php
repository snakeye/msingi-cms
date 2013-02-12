<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Db_Table_ObjectDictionary extends Msingi_Db_Table
{

	/**
	 *
	 * @param type $object_id
	 * @param string $language
	 * @return array
	 */
	public function fetchPairs($object_id, $language)
	{
		$select = $this->select()->from($this, array())
				->joinLeft('dictionary', $this->_name . '.dictionary_id = dictionary.id', array('name'))
				->joinLeft('dictionary_labels', $this->_name . '.dictionary_id = dictionary_labels.row_id', array('label'))
				->where('object_id = ?', $object_id)
				->where('language = ?', $language)
				->group('dictionary.id')
				->order('label')
				->setIntegrityCheck(false);

		return $this->getAdapter()->fetchPairs($select);
	}

	/**
	 *
	 * @param type $object_id
	 * @param type $list
	 */
	public function updateList($object_id, $list)
	{
		$dictionary = new Msingi_Model_Dictionary();

		// get current list
		$select = $this->select()->from($this, array())
				->joinLeft('dictionary', $this->_name . '.dictionary_id = dictionary.id', array('name'))
				->where('object_id = ?', $object_id)
				->group('name')
				->setIntegrityCheck(false);

		$current = $this->fetchAll($select);

		// delete items not found in new list
		foreach ($current as $item)
		{
			if (!in_array($item->name, array_keys($list)))
			{
				$dictionary_id = $dictionary->findId($this->_dictionary, (string) $item->name);

				if ($dictionary_id != 0)
				{
					// delete
					$where = $this->getAdapter()->quoteInto('object_id = ?', $object_id)
							. ' AND '
							. $this->getAdapter()->quoteInto('dictionary_id = ?', $dictionary_id);

					$this->delete($where);
				}
			}
		}

		// create new items
		foreach ($list as $name => $label)
		{
			$dictionary_id = $dictionary->findId($this->_dictionary, (string) $name);

			if ($dictionary_id != 0)
			{
				$select = $this->select()->where('object_id = ?', $object_id)
						->where('dictionary_id = ?', $dictionary_id);

				$item = $this->fetchRow($select);

				if ($item == null)
				{
					$item = $this->createRow(array(
						'object_id' => $object_id,
						'dictionary_id' => $dictionary_id,
							));

					$item->save();
				}
			}
		}
	}

}