<?php
/**
 * @author Mougrim <rinat@mougrim.ru>
 */

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once __DIR__ . '/../framework/SF.php';
SF::createApplication(__DIR__ . '/../config/console.php')->run();
