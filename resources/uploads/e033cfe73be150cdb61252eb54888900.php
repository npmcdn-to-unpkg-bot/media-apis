<?php

/**
* BasePlugin class
* @author Sandro Rybarik
* @date 2016
**/

namespace Backend\Plugins;

abstract class BasePlugin {

	/**
	* 
	* Executed while installing
	*
	**/

	abstract protected function install();

	/**
	* 
	* Executed while uninstalling
	*
	**/
	abstract protected function uninstall();

	/**
	* 
	* 
	*
	**/
	


}