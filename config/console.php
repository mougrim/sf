<?php
/**
 * @author Mougrim <rinat@mougrim.ru>
 */
return array(
	'id'            => 'Hello',
	'namespace'     => 'Mougrim',
	'class'         => '\SF\Console\Application',
	'basePath'      => dirname(__DIR__),
	'defaultRoute'  => array('help', 'index'),
	'components'    => array(
		'request'   => array(
			'class'     => '\SF\Web\Request',
		),
	),
);
