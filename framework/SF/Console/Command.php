<?php
namespace SF\Console;

use SF\Exception;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
abstract class Command {
	protected $defaultAction = 'index';
	protected $config;
	protected $configParams = array();
	private $application;
	private $id;
	private $actionId;

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

	public function getActionId() {
		return $this->actionId;
	}

	public function run($actionId, array $config) {
		$this->actionId = $actionId;
		if(!$this->actionId) {
			$this->actionId = $this->defaultAction;
		}
		$this->actionId = preg_replace('/[^\w]/', '', $this->actionId);
		$this->config = $config;
		$methodName   = 'action' . ucfirst($this->actionId);
		if(!method_exists($this, $methodName)) {
			throw new Exception("Action '{$this->actionId}' not found");
		}
		$this->$methodName();
	}
}
