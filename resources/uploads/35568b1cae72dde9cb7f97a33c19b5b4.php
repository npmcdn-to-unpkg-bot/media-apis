<?php


namespace Backend\Plugins;

use Backend\Plugins\BasePlugin as Base;

class MyPlugin extends Base {

	
	protected function install(){
		echo "succesful installed";
	}
	

	protected function uninstall(){
		echo "succesful uninstall, clearing all files";
	}

	public function __construct(){
		$this->install();
	}

}