<?php
namespace SF;

/**
 * todo default components
 * @method \SF\Web\Request getRequest()
 *
 * @author Mougrim <rinat@mougrim.ru>
 */
class Application extends Factory {
	private $id;
	private $namespace = '';
	private $basePath;
	private $defaultRoute;
	private $errorRoute;

	public function __construct($config) {
		parent::__construct($config['components']);
		unset($config['components']);
		foreach($config as $property => $value) {
			$this->$property = $value;
		}

		\SF::addAutoLoadPath($this->basePath . '/application');
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getNamespace()
	{
		return $this->namespace;
	}

	/**
	 * @return string
	 */
	public function getDefaultRoute()
	{
		return $this->defaultRoute;
	}

	/**
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->basePath;
	}

	protected function processRequest() {
		try {
			$route = $this->getRequest()->getPathInfo();
			if(!$route) {
				if($this->defaultRoute) {
					$route = $this->defaultRoute;
				} else {
					throw new HttpException(404);
				}
			}

			$this->runController($route);
		} catch(HttpException $exception) {
			if (!headers_sent()) {
				header("HTTP/1.0 {$exception->statusCode} {$exception->getName()}");
			} else {
				// todo log exception
			}

			if($this->errorRoute) {
				$this->runController($this->errorRoute);
			}
		}
	}

	protected function runController($route) {
		$controller = '';
		$action = '';
		$parts = explode('/', $route);
		if(isset($parts[0])) {
			$controller = $parts[0];
		}
		if(isset($parts[1])) {
			$action = $parts[1];
		}

		$controllerClassName = "\\{$this->id}\\Controller\\" . ucfirst($controller);
		if($this->namespace) {
			$controllerClassName = "\\{$this->namespace}{$controllerClassName}";
		}

		if(!class_exists($controllerClassName)) {
			throw new HttpException(404, 'Controller not found');
		}

		/** @var Controller $controller */
		$controller = new $controllerClassName($controller);

		$controller->run($action);
	}

	public function run() {
		$this->beforeRun();
		$this->processRequest();
		$this->afterRun();
	}

	protected function beforeRun() {}

	protected function afterRun() {}
}
