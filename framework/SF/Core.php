<?php
namespace SF;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Core {
	private static $application;
	protected static $autoLoadPaths = array();

	/**
	 * @param array|string $config
	 * @return Application
	 * @throws Exception
	 */
	public static function createApplication($config) {
		if(!is_null(self::$application)) {
			throw new Exception("Application is created");
		}

		if(!is_array($config)) {
			$config = require $config;
		}

		$class = '\SF\Application';
		if(array_key_exists('class', $config)) {
			$class = $config['class'];
		}

		self::$application = new $class($config);
		return self::$application;
	}

	/**
	 * @return Application
	 * @throws Exception
	 */
	public static function app() {
		if(!is_null(self::$application)) {
			throw new Exception("Application is created");
		}

		return self::$application;
	}

	public static function addAutoLoadPath($path) {
		static::$autoLoadPaths[] = $path;
	}

	public static function autoLoad($className) {
		// follow PSR-0 to determine the class file
		if(($pos = strrpos($className, '\\')) !== false) {
			// namespaced class
			$file = '/' . str_replace('\\', '/', substr($className, 0, $pos + 1))
				. str_replace('_', '/', substr($className, $pos + 1)) . '.php';
		} else {
			$file = '/' . str_replace('_', '/', $className) . '.php';
		}

		foreach(static::$autoLoadPaths as $path) {
			if(is_file($path . $file)) {
				require_once $path . $file;
				return true;
			}
		}

		return false;
	}
}
