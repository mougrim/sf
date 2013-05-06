<?php
namespace Mougrim\Hello\Controller;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class Site extends \SF\Controller {
	public function actionIndex() {
		echo "index";
	}

	public function actionError() {
		// todo get error code
		echo "error";
	}
}
