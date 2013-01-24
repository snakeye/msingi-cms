<?php

class Msingi_Application_Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{

	protected $_cache;

	/**
	 *
	 */
	public function init()
	{
		return $this->getCache();
	}

	/**
	 *
	 * @return type
	 */
	public function getCache()
	{
		if ($this->_cache == null)
		{
			$options = $this->getOptions();

			$frontendOptions = array(
				'cache_id_prefix' => $options['prefix'],
				'automatic_serialization' => true,
				'lifetime' => $options['lifetime'],
			);

			$backendOptions = array();
			switch ($options['engine'])
			{
				case 'File':
					$cache_dir = $options['file']['dir'];
					if ($cache_dir == '')
					{
						throw new Zend_Application_Resource_Exception('Please set directory for File cache');
					}
					if (!is_dir($cache_dir))
					{
						mkdir($cache_dir, 0777, true);
					}
					$backendOptions['cache_dir'] = realpath($options['file']['dir']);
					break;
				case 'Memcache':
					break;
				case 'XCache':
					$backendOptions['user'] = realpath($config->cache->xcache->user);
					$backendOptions['password'] = realpath($config->cache->xcache->password);
					break;
				default:
			}

			$cache = Zend_Cache::factory('Core', $options['engine'], $frontendOptions, $backendOptions);

			Zend_Translate::setCache($cache);
			Zend_Currency::setCache($cache);
			//Zend_Paginator::setCache($cache);

			Zend_Registry::set('Zend_Cache', $cache);

			$this->_cache = $cache;
		}

		return $this->_cache;
	}

}