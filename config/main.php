<?php
/**
 * @author Mougrim <rinat@mougrim.ru>
 */
return array(
	'id'            => 'Hello',
	'namespace'     => 'Mougrim',
	'basePath'      => dirname(__DIR__),
	'defaultRoute'  => 'site/index',
	'errorRoute'    => 'site/error',
	'components'    => array(
		'request'   => array(
			'class'     => '\SF\Web\Request',
		),
	),
);
