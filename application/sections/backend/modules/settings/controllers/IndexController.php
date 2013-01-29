<?php

class Settings_IndexController extends Msingi_Controller_Backend_Settings
{

	protected function _init()
	{
		$languages = new Msingi_Model_Constants_Languages();
		$timezones = new Msingi_Model_Constants_Timezones();

		$this->_settings = array(
			array(
				'label' => $this->_('General settings'),
				'icon' => 'icon-wrench',
				'settings' => array(
					array(
						'name' => 'app_name',
						'label' => $this->_('Application name'),
						'setting' => 'application:name',
						'type' => 'string',
					),
					array(
						'name' => 'app_tagline',
						'label' => $this->_('Application tagline'),
						'setting' => 'application:tagline',
						'type' => 'string',
					),
					array(
						'name' => 'timezone',
						'label' => $this->_('Time zone'),
						'setting' => 'application:timezone',
						'type' => 'select',
						'options' => $timezones->getPairs(false),
					),
					array(
						'name' => 'admin_email',
						'label' => $this->_('Admin email'),
						'setting' => 'application:admin_email',
						'type' => 'string',
					),
				)
			),
			array(
				'label' => $this->_('Mail settings'),
				'icon' => 'icon-envelope',
				'settings' => array(
					array(
						'name' => 'mail_from',
						'label' => $this->_('Email from address'),
						'setting' => 'mailer:default:from',
						'type' => 'string',
					),
					array(
						'name' => 'mail_send',
						'label' => $this->_('Really send messages'),
						'setting' => 'mailer:default:send',
						'type' => 'checkbox',
					),
					array(
						'name' => 'mail_log',
						'label' => $this->_('Log sent messages'),
						'setting' => 'mailer:default:log',
						'type' => 'checkbox',
					),
				)
			),
			array(
				'label' => $this->_('Multilanguage settings'),
				'icon' => 'icon-plane',
				'form' => 'Form_Settings_Multilanguage',
				'view' => 'multilanguage',
			),
			array(
				'label' => $this->_('Performance settings'),
				'icon' => 'icon-cog',
				'settings' => array(
					array(
						'name' => 'minify_html',
						'label' => $this->_('Minify HTML code'),
						'setting' => 'performance:html:minify',
						'type' => 'checkbox',
					),
//					array(
//						'name' => 'inline_css',
//						'label' => $this->_('Put CSS inline'),
//						'setting' => 'performance:html:inline_css',
//						'type' => 'checkbox',
//					),
//					array(
//						'name' => 'inline_js',
//						'label' => $this->_('Put JS inline'),
//						'setting' => 'performance:html:inline_js',
//						'type' => 'checkbox',
//					),
					array(
						'name' => 'html_conditional',
						'label' => $this->_('Process HTML Conditional requests'),
						'setting' => 'performance:html:conditional',
						'type' => 'checkbox',
					),
					array(
						'name' => 'cache_control',
						'label' => $this->_('Send Cache-control header'),
						'setting' => 'performance:html:cache_control',
						'type' => 'checkbox',
					),
					array(
						'name' => 'cache_time',
						'label' => $this->_('Cache-control timeout value'),
						'setting' => 'performance:html:cache_timeout',
						'type' => 'string',
					)
				)
			),
			array(
				'label' => $this->_('Google Analytics'),
				'icon' => 'icon-info-sign',
				'settings' => array(
					array(
						'name' => 'google_analytics',
						'label' => $this->_('Google Analytics ID'),
						'setting' => 'google:analytics:id',
						'type' => 'string',
					),
				)
			),
		);
	}

	/**
	 *
	 */
	public function preDispatch()
	{
		parent::preDispatch();

		$rq = $this->getRequest();

		if ($rq->isPost())
		{
			$post = $rq->getPost();
			$section_id = intval($post['section']);
		}
		else
		{
			$section_id = intval($rq->get('section'));
		}

		$this->view->layout()->sidebar = $this->view->partial('_sidebar.phtml', array('settings' => $this->_settings, 'current' => $section_id));
	}

}