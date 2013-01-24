<?php

class Msingi_View_Helper_Partial extends Zend_View_Helper_Partial
{

	/**
	 *
	 * @param type $name
	 * @param type $module
	 * @param type $model
	 * @return \Msingi_View_Helper_Partial
	 * @throws Zend_View_Helper_Partial_Exception
	 */
	public function partial($name = null, $module = null, $model = null)
	{
		if (0 == func_num_args())
		{
			return $this;
		}

		$view = $this->cloneView();
		if (isset($this->partialCounter))
		{
			$view->partialCounter = $this->partialCounter;
		}
		if ((null !== $module) && is_string($module))
		{
			$sections = Zend_Registry::get('Sections');

			$currentSection = $sections->getCurrentSection();

			$settings = Msingi_Model_Settings::getInstance();

			$theme = $settings->get('section:' . $currentSection->name() . ':appearance:theme', 'default');

			$viewsDir = sprintf('%s/sections/%s/themes/%s/modules/%s', APPLICATION_PATH, $currentSection->name(), $theme, $module);
			if (!is_dir($viewsDir))
			{
				require_once 'Zend/View/Helper/Partial/Exception.php';
				$e = new Zend_View_Helper_Partial_Exception('Cannot render partial; module does not exist');
				$e->setView($this->view);
				throw $e;
			}

			$view->setScriptPath($viewsDir);
		}
		elseif ((null == $model) && (null !== $module) && (is_array($module) || is_object($module)))
		{
			$model = $module;
		}

		if (!empty($model))
		{
			if (is_array($model))
			{
				$view->assign($model);
			}
			elseif (is_object($model))
			{
				if (null !== ($objectKey = $this->getObjectKey()))
				{
					$view->assign($objectKey, $model);
				}
				elseif (method_exists($model, 'toArray'))
				{
					$view->assign($model->toArray());
				}
				else
				{
					$view->assign(get_object_vars($model));
				}
			}
		}

		return $view->render($name);
	}

}