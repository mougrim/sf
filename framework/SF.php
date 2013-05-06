<?php
require_once dirname(__FILE__) . '/SF/Core.php';

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class SF extends \SF\Core {
	protected static $autoLoadPaths = array(__DIR__);
}

spl_autoload_register(array('SF', 'autoLoad'));
