<?php

class Form_Login extends Msingi_Form
{

	public function init()
	{
		$this->setAction('/login');
		$this->setMethod('post');

		$back = $this->createElement('hidden', 'back', array(
			'filters' => array('StringTrim'),
			));

		$username = $this->createElement('text', 'username', array(
			'label' => $this->_('Username'),
			'filters' => array('StringTrim', 'StringToLower'),
			'validators' => array('NotEmpty'),
			'required' => true,
			'class' => 'required',
			'size' => 30,
			));

		$password = $this->createElement('password', 'password', array(
			'label' => $this->_('Password'),
			'filters' => array('StringTrim',),
			'validators' => array('Alnum'),
			'required' => true,
			'class' => 'required',
			'size' => 15
			));

		$submit = $this->createElement('submit', 'submit', array(
			'label' => $this->_('Login'),
			));

		$this->addElements(array($back, $username, $password, $submit));
	}

}