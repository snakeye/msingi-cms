<?php

abstract
class Msingi_Controller_Backend_ListingAbstract extends Msingi_Controller_Backend
{

	protected $_page_size = 15;

	/**
	 * @return Msingi_Db_Table
	 */
	abstract protected function getTable();

	/**
	 * @return Msingi_Form
	 */
	abstract protected function getEditForm();

	/**
	 * @return query object
	 */
	abstract protected function getPaginatorQuery($request, $filter);

	/**
	 * Return array of filter & sort fields
	 * @todo object
	 *
	 * @return array
	 */
	abstract protected function getFilter();

	/**
	 * Provides paginated list of objects
	 */
	public function indexAction()
	{
		$request = $this->getRequest();

		$session_data = new Zend_Session_Namespace(get_class($this));
		if (!isset($session_data->filter))
			$session_data->filter = $this->getFilter();

		$this->view->paginator = Zend_Paginator::factory($this->getPaginatorQuery($request, $session_data->filter));
		$this->view->paginator->setCurrentPageNumber(intval($request->get('page')));
		$this->view->paginator->setItemCountPerPage($this->_page_size);

		$this->view->filter = $session_data->filter;
	}

	/**
	 *
	 */
	public function addAction()
	{
		$form = $this->getEditForm();
		if ($form == null)
			$this->_helper->redirector('index');

		$form->getElement('id')->setValue(-1);

		$this->view->form = $form;

		return $this->render('edit');
	}

	/**
	 *
	 */
	public function editAction()
	{
		$rq = $this->getRequest();

		$form = $this->getEditForm();
		if ($form == null)
			$this->_helper->redirector('index');

		/* @var $table Msingi_Db_Table */
		$table = $this->getTable();

		$row = null;

		if ($rq->isPost())
		{
			if ($form->isValid($rq->getPost()))
			{
				$values = $form->getValues();

				if ($values['id'] == -1)
				{
					unset($values['id']);
					$row = $table->createRow();
					$row->save();
				}
				else
				{
					$row = $table->fetchById($values['id'], false);
					if ($row == null)
					{
						$this->_helper->redirector('index');
					}
				}

				$this->updateRow($row, $values, $form);

				$this->_helper->redirector('index');
			}
		}
		else
		{
			$row = $table->fetchById($rq->get('id'), false);
			if ($row == null)
			{
				$this->_helper->redirector('index');
			}

			$this->onPopulate($form, $row);
		}

		$this->view->object = $row;
		$this->view->form = $form;
	}

	/**
	 *
	 * @param type $form
	 * @param type $row
	 */
	protected function onPopulate($form, $row)
	{
		$form->populate($row);
	}

	/**
	 *
	 * @param type $row
	 */
	protected function onUpdateRow($row)
	{

	}

	/**
	 *
	 * @param type $row
	 * @param type $values
	 * @param type $form
	 */
	protected function updateRow($row, $values, $form)
	{
		$row->setFromArray($values);

		$this->onUpdateRow($row);

		$row->save();
	}

	/**
	 *
	 */
	public function deleteAction()
	{
		$row = $this->getRequestedObject();

		if ($row != null)
		{
			$row->delete();
		}

		return $this->_helper->redirector('index');
	}

	/**
	 *
	 */
	public function viewAction()
	{
		$row = $this->getRequestedObject();

		if ($row == null)
		{
			return $this->_helper->redirector('index');
		}

		$this->view->object = $row;
	}

	/**
	 *
	 */
	public function getRequestedObject()
	{
		$rq = $this->getRequest();

		$table = $this->getTable();

		return $table->fetchById(intval($rq->get('id')));
	}

	/**
	 *
	 */
	public function setfilterAction()
	{
		$rq = $this->getRequest();

		//
		$default_filter = $this->getFilter();

		// get filter
		$session_data = new Zend_Session_Namespace(get_class($this));
		if (isset($session_data->filter))
			$filter = $session_data->filter;
		else
			$filter = $default_filter;

		// update field values
		foreach ($default_filter as $field => $value)
		{
			if ($field != 'sort')
				$filter[$field] = trim($rq->get($field));
		}

		//
		$session_data->filter = $filter;

		return $this->_helper->redirector('index');
	}

	/**
	 *
	 * @return type
	 */
	public function setsortAction()
	{
		$rq = $this->getRequest();

		$session_data = new Zend_Session_Namespace(get_class($this));
		if (isset($session_data->filter))
			$filter = $session_data->filter;
		else
			$filter = $this->getFilter();

		//
		$field = trim($rq->get('field'));
		if ($field != '')
		{
			$sort = $filter['sort'];
			$sort_field = current(array_keys($sort));
			$sort_dir = $filter['sort'][$sort_field];

			if ($sort_field != $field)
			{
				$sort = array($field => 'asc');
			}
			else
			{
				if ($sort_dir == 'asc')
					$sort_dir = 'desc';
				else
					$sort_dir = 'asc';

				$sort = array($sort_field => $sort_dir);
			}

			$filter['sort'] = $sort;

			//
			$session_data->filter = $filter;
		}

		return $this->_helper->redirector('index');
	}

}