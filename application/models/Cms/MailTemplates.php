<?php

/**
 * @package MsingiCms
 * @author Andrey Ovcharov <andrew.ovcharov@gmail.com>
 */
class Cms_MailTemplatesTable extends Msingi_Db_Table_Multilanguage
{

	protected $_name = 'cms_mail_templates';
	protected $_rowClass = 'Cms_MailTemplate';

}