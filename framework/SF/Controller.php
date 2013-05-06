<?php
namespace SF;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Controller {
	private $id;
	private $actionId;

	public function __construct($id) {
		$this->id = $id;
	}

	public function run($actionId) {
		$this->actionId = $actionId;

		$actionMethodName = 'action' . ucfirst($this->actionId);

		if(!method_exists($this, $actionMethodName)) {
			throw new HttpException(404, 'Action not found');
		}

		$this->$actionMethodName();
	}
}
