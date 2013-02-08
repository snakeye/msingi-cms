<?php

class Translations_IndexController extends Msingi_Controller_Backend
{

	protected $_page_size = 10;

	/**
	 *
	 * @return type
	 */
	public function indexAction()
	{
		$rq = $this->getRequest();

		$language = trim($rq->get('language'));
		if ($language == '')
			$language = Msingi_Model_Settings::getInstance()->get('section:frontend:languages:default');

		if ($rq->isPost())
		{
			$post = $rq->getPost();

			$have_updates = false;

			foreach ($post as $input => $value)
			{
				if (preg_match('/translation_(\d+)/', $input, $matches))
				{
					$translation = Msingi_Model_Translations::getInstance()->fetchById($matches[1]);

					if ($translation != null)
					{
						$value = trim($value);

						if ($translation->translation != $value)
						{
							$translation->translation = $value;
							$translation->save();

							$have_updates = true;
						}
					}
				}
			}

			if ($have_updates)
			{
				Zend_Translate::clearCache();
			}

			return $this->_helper->redirector('index', 'index', 'translations', array('language' => $language));
		}

		// sidebar
		$filter = $this->getFilter();
		$this->view->layout()->sidebar = $this->view->partial('index/_sidebar.phtml', array('language' => $language, 'filter' => $filter));

		// main content
		$this->view->paginator = Msingi_Paginator::createFromSelect(Msingi_Model_Translations::getInstance()->selectAll($language, $filter), $rq->get('page'), $this->_page_size);
		$this->view->language = $language;
	}

	/**
	 *
	 * @return type
	 */
	public function filterAction()
	{
		$rq = $this->getRequest();

		if (!$rq->isPost())
		{
			return $this->_helper->redirector('index', 'index', 'translations');
		}

		$post = $rq->getPost();

		$language = trim($post['language']);

		// get filter
		$filter = $this->getFilter();

		//
		$filter['search'] = trim(strip_tags($post['search']));
		$filter['untranslated'] = $post['untranslated'] != '' ? true : false;

		$this->setFilter($filter);

		return $this->_helper->redirector('index', 'index', 'translations', array('language' => $language));
	}

	/**
	 *
	 * @return string
	 */
	protected function getFilter()
	{
		$session_data = new Zend_Session_Namespace(get_class($this));

		if (isset($session_data->filter))
			$filter = $session_data->filter;
		else
			$filter = array('search' => '', 'untranslated' => false);

		return $filter;
	}

	/**
	 *
	 * @param type $filter
	 */
	protected function setFilter($filter)
	{
		$session_data = new Zend_Session_Namespace(get_class($this));

		$session_data->filter = $filter;
	}

}