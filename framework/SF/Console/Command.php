<?php
namespace SF\Console;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
abstract class Command {
	protected $defaultAction = 'index';
	protected $action;
	protected $config;
	protected $configParams = array();

	public function run($action, array $config) {
		$this->action = $action;
		if(!$this->action) {
			$this->action = $this->defaultAction;
		}
		$this->action = preg_replace('/[^\w]/', '', $this->action);
		$this->config = $config;
		$methodName = 'action' . ucfirst($this->action);
		if(!method_exists($this, $methodName)) {
			throw new \SF\Exception("Action '{$this->action}' not found");
		}
		$this->$methodName();
	}
}
