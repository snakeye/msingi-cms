<?php

/**
 * @package Msingi
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Msingi_Controller_Backend_Dictionaries extends Msingi_Controller_BackendAbstract
{

	protected $_dictionaries;

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$this->_init();
	}

	/**
	 *
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		$form = new Form_Settings();
		$dictionary = new Cms_Dictionaries();

		if ($rq->isPost())
		{
			$post = $rq->getPost();

			$type = trim($post['type']);
			$labels = $dictionary->fetchLabels($type);

			foreach ($post as $var => $val)
			{
				if (preg_match('/label_([a-z0-9]+)_([a-z0-9]+)/', $var, $m))
				{
					$val = trim(strip_tags($val));
					$name = $m[1];
					$language = $m[2];

					if (@$labels[$name][$language] != $val)
					{
						$dictionary->setLabel($type, $name, $language, $val);
					}
				}
			}

			return $this->_helper->redirector('index', 'dictionaries', 'default', array('dictionary' => $type));
		}
		else
		{
			$type = $rq->get('dictionary');
			if (!isset($this->_dictionaries[$type]))
			{
				$types = array_keys($this->_dictionaries);
				$type = $types[0];
			}
			$current = $this->_dictionaries[$type];
		}

		$this->view->languages = Msingi_Application_Settings::getInstance()->getArray('multilanguage:languages');

		$this->view->type = $type;
		$this->view->items = $dictionary->fetchLabels($type);

		$this->view->dictionary_label = $current['label'];

		$this->view->layout()->sidebar = $this->view->partial('dictionaries/_sidebar.phtml', array('dictionaries' => $this->_dictionaries));
	}

	/**
	 *
	 */
	public function addAction()
	{
		$rq = $this->getRequest();

		if (!$rq->isPost())
			return $this->_helper->redirector('index', 'dictionaries', 'default');

		$post = $rq->getPost();

		$type = trim($post['type']);
		if (!isset($this->_dictionaries[$type]))
			return $this->_helper->redirector('index', 'dictionaries', 'default');

		$name = trim(strip_tags($post['name']));
		$name = preg_replace('/[^a-z0-9]/i', '', $name);
		$name = strtolower($name);

		if ($name != '')
		{
			$dictionary = new Cms_Dictionaries();

			$row = $dictionary->fetchRow(array(
				'type = ?' => $type,
				'name = ?' => $name
					));

			if ($row == null)
			{
				$row = $dictionary->createRow(array(
					'type' => $type,
					'name' => $name,
						));

				$row->save();
			}
		}
		return $this->_helper->redirector('index', 'dictionaries', 'default', array('dictionary' => $type));
	}

	/**
	 * Delete record from the dictionary
	 */
	public function deleteAction()
	{
		$rq = $this->getRequest();

		$type = trim($rq->get('type'));
		$name = trim($rq->get('name'));

		if ($type != '' && $name != '')
		{
			$dictionary = new Cms_Dictionaries();

			$row = $dictionary->fetchRow(array(
				'type = ?' => $type,
				'name = ?' => $name
					));

			if ($row != null)
			{
				$row->delete();
			}
		}

		return $this->_helper->redirector('index', 'dictionaries', 'default', array('dictionary' => $type));
	}

}

