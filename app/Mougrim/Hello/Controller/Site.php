<?php
namespace Mougrim\Hello\Controller;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Site extends \SF\Controller {
	public function actionIndex() {
		echo "hellow world";
	}

	public function actionError() {
		// todo get error code
		echo "error";
	}
}
