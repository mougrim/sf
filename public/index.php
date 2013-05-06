<?php
/**
 * @author Mougrim <rinat@mougrim.ru>
 */

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__FILE__) . '/../framework/SF.php';
SF::createApplication(dirname(__FILE__) . '/../config/main.php')->run();
