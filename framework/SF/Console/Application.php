<?php
namespace SF\Console;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Application extends \SF\Application {
	private $_scriptName;

	protected function processRequest() {
		$args = $_SERVER['argv'];
		$this->_scriptName = array_shift($args);
		if(empty($args)) {
			$args = $this->getDefaultRoute();
		}
		list($commandName, $action, $config) = $this->resolveRequest($args);var_dump($commandName, $action, $config);
		$commandName = preg_replace('/[^\w]/', '', $commandName);
		$commandClassName = "\\{$this->getId()}\\Command\\" . ucfirst($commandName);
		if($this->getNamespace()) {
			$commandClassName = "\\{$this->getNamespace()}{$commandClassName}";
		}
		if(!class_exists($commandClassName)) {
			throw new \SF\Exception("Command {$commandName} not found");
		}
		/** @var $command Command */
		$command = new $commandClassName($commandName);
		$command->run($action, $config);
	}

	protected function resolveRequest($args) {
		$command = null;
		$action = null;
		$config = array();

		foreach($args as $param) {
			if(preg_match('/^--([a-z\d](?:[a-z\d-]*[a-z\d])?)(?:=(.+))?$/i', $param, $matches)) {
				if(isset($matches[2])) {
					$config[$matches[1]] = $matches[2];
				} else {
					$config[$matches[1]] = true;
				}
			} elseif($command === null) {
				$command    = $param;
			} elseif($action === null) {
				$action     = $param;
			} else {
				$config[]   = $param;
			}
		}

		// todo default params
//		if(array_key_exists($this->action, $this->configParams)) {
//			foreach($this->configParams[$this->action] as $key => $params) {
//				if(array_key_exists($key, $config)) {
//					switch($params['type'])
//					{
//						case 'string':
//							$config[$key] = (string) $config[$key];
//							break;
//						default:
//							throw new \SF\Exception("Unknown type '{$params['type']}'");
//					}
//				} elseif($params['isRequired']) {
//					throw new \SF\Exception("{$key} is required param");
//				} elseif(array_key_exists('default', $params)) {
//					$config[$key] = $params['default'];
//				} else {
//					$config[$key] = null;
//				}
//			}
//		}
		return array($command, $action, $config);
	}

	public function getScriptName() {
		return $this->_scriptName;
	}

	public function getPwd() {
		return $_SERVER['PWD'];
	}
}
