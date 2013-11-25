<?php
namespace SF;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Factory {
	private $componentsConfig;
	private $components = array();

	public function __construct(array $componentsConfig) {
		$this->componentsConfig = $componentsConfig;
	}

	public function __call($method, $args) {
		$prefix = substr($method, 0, 3);
		$name   = lcfirst(substr($method, 3));

		if($prefix === 'get') {
			if(array_key_exists($name, $this->components)) {
				return $this->components[$name];
			}

			if(array_key_exists($name, $this->componentsConfig)) {
				$componentConfig = $this->componentsConfig[$name];
				if(
					array_key_exists('__constructor', $componentConfig) &&
					$componentConfig['__constructor'] &&
					is_array($componentConfig['__constructor'])
				) {
					$reflectionClass         = new \ReflectionClass($componentConfig['class']);
					$this->components[$name] = $reflectionClass->newInstanceArgs($componentConfig['__constructor']);
				} else {
					$this->components[$name] = new $componentConfig['class']();
				}
				unset($componentConfig['class']);

				foreach($componentConfig as $propertyName => $value) {
					if(strpos($propertyName, '__') !== 0) {
						$this->components[$name]->$propertyName = $value;
					}
				}

				return $this->components[$name];
			}
		} elseif($prefix === 'set' && count($args) === 1) {
			if(
				array_key_exists($name, $this->componentsConfig) &&
				$args[0] instanceof $this->components[$name]['class']
			) {
				$this->components[$name] = $args[0];
			}
		}

		throw new Exception("Component {$name} not found");
	}
}
