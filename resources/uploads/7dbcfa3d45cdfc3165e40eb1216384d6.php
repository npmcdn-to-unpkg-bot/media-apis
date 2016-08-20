<?php

namespace Backend\Plugins;



class PluginManager{
	
	private $plugins = [];
	private $appInstance;

	public function __construct (\Silex\Application $app){
		$this->appInstance = $app;
	}

	public function register ($pluginClass, $name){
		$obj = new $pluginClass($this->appInstance);
		$this->plugin[$name] = $obj;
	}

	public function use ($name){
		//return instance
		return $this->plugin[$name];
	}

	public function register2($something){
		$this->plugins[] = $something;
	}
	public function dump (){
		var_dump($this->plugins);
	}

}