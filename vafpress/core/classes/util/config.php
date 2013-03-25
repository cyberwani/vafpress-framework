<?php

/**
 * Config files loader
 */

class VP_Util_Config
{

	private static $_instance;

	private $_configs;

	private function __construct()
	{
		$this->_configs = array();
	}

	public static function get_instance()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	public function load($config_name, $key = '')
	{
		// get the config, try to get in memory cache
		if (array_key_exists($config_name, $this->_configs))
		{
			$config = $this->_configs[$config_name];
		}
		else
		{
			$app_config  = array();
			$core_config = array();
			$any_loaded  = false;
			
			// get app config
			if(is_file(VP_APP_CONFIG_DIR . '/'. $config_name . '.php'))
			{
				$app_config = require VP_APP_CONFIG_DIR . '/'. $config_name . '.php';
				$any_loaded = true;
			}
			
			// get core config
			if(is_file(VP_CORE_CONFIG_DIR . '/'. $config_name . '.php'))
			{
				$core_config = require VP_CORE_CONFIG_DIR . '/'. $config_name . '.php';
				$any_loaded = true;
			}

			if(!$any_loaded) throw new Exception("$config_name file not found.\n", 1);

			// merge if they both exists, with app config being the priority
			$config = VP_Util_Array::array_replace_recursive($core_config, $app_config);

			// cache 'em
			$this->_configs[$config_name] = $config;
		}

		// if key supplied, get the specific index of config array
		$temp = $config;
		if($key !== '')
		{
			$keys = explode('.', $key);
			foreach ($keys as $key)
			{
				$temp = $temp[$key];
			}
		}
		return $temp;
	}

}