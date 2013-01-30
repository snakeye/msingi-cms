<?php

/**
 * @package MsingiCms
 */
class Form_User extends Msingi_Form
{

	public function init()
	{
		$this->setAction('/admins/edit');
		$this->setMethod('post');

		$id = $this->createElement('hidden', 'id');

		$name = $this->createElement('text', 'name', array(
			'label' => $this->_('Name'),
			'class' => 'txt title',
			'filters' => array('StringTrim', 'StripTags'),
			));

		// @todo validate username is unique
		$username = $this->createElement('text', 'username', array(
			'label' => $this->_('User name'),
			'class' => 'txt',
			'filters' => array('StringTrim', 'StringToLower', 'StripTags'),
			'validators' => array(),
			'required' => true,
			));

		$email = $this->createElement('text', 'email', array(
			'label' => $this->_('E-mail'),
			'filters' => array('StringToLower', 'StringTrim', 'StripTags'),
			'validators' => array('EmailAddress'),
			'required' => true,
			));

		$roles = $this->createElement('select', 'role', array(
			'label' => $this->_('Role'),
			'filters' => array('StringTrim', 'StripTags'),
			'required' => true,
			));

		// @todo validate password
		$password1 = $this->createElement('password', 'password1', array(
			'label' => $this->_('Password'),
			'filters' => array('StringTrim', 'StripTags'),
			'validators' => array(),
			));

		$password2 = $this->createElement('password', 'password2', array(
			'label' => $this->_('Repeat password'),
			'filters' => array('StringTrim', 'StripTags'),
			'validators' => array(),
			));

		$this->addElements(array($id, $name, $username, $email, $roles))
			->addElements(array($password1, $password2))
			->addElement('submit', 'save', array('label' => $this->_('Save'), 'class' => 'btn btn-primary'));
	}

}