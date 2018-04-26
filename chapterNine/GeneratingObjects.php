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


/******* Factory Method Pattern **********/

// Problem: 
/* 
This method relies on composition, polymorphism (using conditionals), to generate objects. Caution should be exercised  when conditionals start getting repetitive as the case would most certainly turn out to be.

You have been put in charge of an appointment manager that needs to communicate with third parties in their compatible formats respectively... an implementation would look like this

*/

/*
abstract class AppEncoder {
	abstract function encode();
}

class BlogEncoder extends AppEncoder {
	function encode() {
		// Get appointment in blog format
	}
}

class ComsEncoder extends AppEncoder {
	function encode() {
		// Get appointment in coms format
	}
}

class CommsManager {
	const BLOG = 1;
	const COMMS = 2;
	private $mode;

	function __construct ($mode) {
		$this->mode = $mode;
	}

	static function getAppEncoder() {
		switch (SELF::mode) {
			case 'SELF::BLOG':
				return new BlogEncoder(); // Composition
				break;
			case 'SELF::COMMS':
				return new ComsEncoder();
				break;
		}
	}
}

*/

// Issue arises when we need to add more methods to the CommsManager class, we start having repetitive conditionals

/*
	... function getHeader() {
		switch (SELF::mode) {
			case 'SELF::BLOG':
				// code for header blog
				break;
			case 'SELF::COMMS':
				// code for header comms
				break;
		}
	}

	... function getFooter() {
		switch (SELF::mode) {
			case 'SELF::BLOG':
				// code for footer blog
				break;
			case 'SELF::COMMS':
				// code for footer comms
				break;
		}
	}
*/

// Implementation: 
// One way to go is to create sub classes that implement specific types of formats to be communicated

/*

abstract class AppEncoder {
	abstract function encode();
}

class BlogEncoder extends AppEncoder {
	function encode() {
		// Get appointment in blog format
	}
}

class ComsEncoder extends AppEncoder {
	function encode() {
		// Get appointment in coms format
	}
}

abstract class CommsManager {
	abstract function getAppEncoder();
	abstract function getHeader();
	abstract function getFooter();
}

class BlogsComm extends CommsManager {
	function getAppEncoder () {
		// implementation for BlogsComm
	}

	function getHeader () {
		// implementation for BlogsComm
	}

	function getFooter () {
		// implementation for BlogsComm
	}

}


class ComsComs extends CommsManager {
	function getAppEncoder () {
		// implementation for ComsComs
	}

	function getHeader () {
		// implementation for ComsComs
	}

	function getFooter () {
		// implementation for ComsComs
	}

}

*/

// This way each implementation can be handled in each child class

// Consequences: 
// This pattern also leads to a sort of code duplication and creation of unnecessary child classes


/******* Abstract Factory Pattern **********/ // (To be revisited)
// Problem: 

// Implementation:

// Consequences: This pattern is closely related to the factory method pattern. As the system grows, this implies more inheritance hierarchies and more metho implementation per sub class
// this can be relatively inflexible and difficult to manage


/******** Prototype Pattern **********/

// Problem: This pattern aims to create a more flexible approach to creating objects. This is done by creating a blueprint/prototype containing all objects that may be neeeded during runtime



// Implementation:
/*

class Sea {}
class EarthSea extends Sea {}
class MarsSea extends Sea {}

class Forest {}
class EarthForest extends Forest {}
class MarsForest extends Forest {}

class Plains {}
class EarthPlains extends Plains {}
class MarsPlains extends Plains {}

// Factory class for generating objects

class TerrainFactory {
	private $sea;
	private $forest;
	private $plains;
	public function __construct (Sea $sea, Forest $forest, Plains $plains) {
		$this->sea = $sea;
		$this->forest = $forest;
		$this->plains = $plains;
	}

	function getSea() {
		return clone $this->sea;
	}

	function getForest() {
		return clone $this->forest;
	}

	function getPlain() {
		return clone $this->plains;
	}
}


// Example

$terrains = new TerrainFactory (new Sea(), new Forest(), new Plains());

$terrains->getForest(); // return clone of forest object

*/



// Consequences:
