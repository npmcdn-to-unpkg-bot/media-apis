<?php


namespace Backend\Plugins;


class PluginCollection {

	private $plugins = [];

	public function register ($plugin, $name){
		$this->plugins[$name] = $plugin;
	}

	public static function use ($name){
		return $this->plugins[$name];
	}


	
}