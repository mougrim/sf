<?php
namespace Mougrim\Hello\Command;

class Help extends \SF\Console\Command
{
	public function actionIndex()
	{
		echo "List of commands:
	help
";
	}
}
