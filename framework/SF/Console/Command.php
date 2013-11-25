<?php
namespace SF\Console;

use SF\Exception;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
abstract class Command {
	protected $defaultAction = 'index';
	protected $action;
	protected $config;
	protected $configParams = array();
	private $application;
	private $id;

	public function __construct(Application $application, $id) {
		$this->application = $application;
		$this->id          = (string) $id;
	}

	/**
	 * @return Application
	 */
	protected function getApplication() {
		return $this->application;
	}

	public function getId() {
		return $this->id;
	}

	public function run($action, array $config) {
		$this->action = $action;
		if(!$this->action) {
			$this->action = $this->defaultAction;
		}
		$this->action = preg_replace('/[^\w]/', '', $this->action);
		$this->config = $config;
		$methodName   = 'action' . ucfirst($this->action);
		if(!method_exists($this, $methodName)) {
			throw new Exception("Action '{$this->action}' not found");
		}
		$this->$methodName();
	}
}
