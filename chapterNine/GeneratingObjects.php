<?php
/************************************************************* Pattern for generating objects ************************************************************/

/*
*	Chapter covers:
*	The Singleton pattern
*	The Factory pattern
*	The Abstract Factory pattern
*	The Prototype pattern
*/

/************* The Singleton pattern ************/

// Problem-case: A system where a configuration-object needs to be passed around other objects in the system, to determine which actions to take can end up
// being altered and misused. Care needs to be taken on how the configuration-object is instantiated

// Implementation: We could enforce instantiation of the object from within the class alone, this is done by setting "__construct()" method to private and 
// using static to generate instances that will be accessible across the system and global in nature

/* 
 class Configuration {
 	private $props = array();
	private static $instance; // A static method can only access static properties;

	private function __construct() {} // this ensures the class cannot be instantiated outside the class

	public static function getInstance() {
		if ( empty(self::$instance) ) {
			self::$instance = new Configuration();
		}
		return self::$instance; // Return the newly instantiated class
	}
	public function setProp($name, $value) {
		$this->props[$name] = $value;
	}

	public function getProps($name) {
		return $this->props[$name];
	}
	// Other configuration methods
 }

// Get instance
 $conf = Configuration::getInstance();

// set config values
$conf->setProp('method', 'post');

// Destroy instance
unset($conf);

// Get instance again
$confResurrected = Configuration::getInstance();

// get config values
echo $confResurrected->getProp('method'); // prints "post" because the instance created before is still alive in php
*/


// Consequences: Using Singletons, means that we are passing around objects that client code doesn't really understand since the instantiation is hidden behind the class interface. 
// one way to solve this is use a comment or doc when the singleton class is being declared/used as the case may be


/******* Factory Method Patter **********/
// 

// Problem: 
// Implementation: 
// Consequences: 
