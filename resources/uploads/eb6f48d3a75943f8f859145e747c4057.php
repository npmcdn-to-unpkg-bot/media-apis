<?php


namespace Backend\Plugins;



class PluginManagerFacade {
	private static $manager;
	public function __construct (\Backend\Plugins\PluginManager $manager){
		self::$manager = $manager;
	}
	public static function register2($something){
		self::$manager -> register2($something);
	}

}