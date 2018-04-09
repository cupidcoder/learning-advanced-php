<?php
/************************************************************* Object Tools ************************************************************/

/*
*	Chapter covers:
*	Packages: Organizing your code into logical categories
*	Namespaces: Since PHP 5.3 you can encapsulate your code elements in discrete compartments
*	Include paths: Setting central accessible locations for your library code
*	Class and object functions: Functions for testing objects, classes, properties, and methods
*	The Reflection API: A powerful suite of built-in classes that provide unprecedented access to class information at runtime
*/

/******************************* Packages: Organizing your code into logical categories **************************************************/

// PHP does not have an intinsic way of organizing code into packages. This means that all data types declared in the global space
// are available to the entire app and this can lead to naming conflicts. PHP 5.3 attempted to solve this issue with namespaces

/******************************* Namespaces **********************************/
// A namespace should be the first declaration in a file

// For example, a file "helpers.php" has a class called "Player"

// In file "index.php", using namespacing, the script won't crash if you declare a class using "Player"

// namespace index;

// require("helpers.php");

// Without namespace, the error "Cannot redeclare class Player in C:\wamp64\www\learning-advanced-php\chapterFive\helpers.php on line 3" is thrown
class Player {
	// Code goes here
}

//*******	Include paths: Setting central accessible locations for your library code ***********/

/*
Manually setting include paths per file can be strenuous and it becomes more messy when the codebase
moves to a different server or file path; meaning all included paths would need to be reset
*/

// This can easily be solved by setting an include_path in the php.ini configuration/ apache configuration (httpd.conf) or .htaccess file

// In the php.ini config file, the directory path "C:wamp64\www\learning-advanced-php\set_include_path_demo.php" was added appended to the include_path making it possible for this script to
// resolve the file "set_include_path_demo.php" and echo $hello without throwing up any errors

// require("set_include_path_demo.php");

// echo $hello;

// Autoload (spl_autoload_register)

/* This is a medium of lazy loading/ including classes (via class files) only when they are needed
** It works by first registering an spl_autoload function using spl_autoload_register('callbackFunction');
** When an unknown class is instantiated, PHP calls the function stated in the autoload function, which in turn, determines the file to be included
** if no function is specified, PHP attempts to find the file name using the class name. 
*/


// spl_autoload_register('getClass');

// $user = new User();


/*
function getClass($className) {
	// This function specifies which file should be included based on the class name requested.
}
*/


// Class or object functions/methods/tools

// class_exists() -> returns a boolean 1/0 if class exists

// get_declared_classes() -> returns an array of all declared classes

// get_class() -> returns a string class name of an object 

// get_class_methods() -> returns an array of all methods of a class

/*****The Reflection API: A powerful suite of built-in classes that provide unprecedented access to class information at runtime*****/

// ShopProduct class from chapter 4

class ShopProduct{
	private $id;
	protected $title = "Title";
	protected $producerFirstName = "First name";
	protected $producerLastName = "Last name";
	protected $price = 0;

	public function __construct($title, $producerFirstName, $producerLastName, $price) {
		$this->title = $title;
		$this->producerFirstName = $producerFirstName;
		$this->producerLastName = $producerLastName;
		$this->price = $price;
	}

	public function setID($id) {
		$this->id = $id;
	}

	public function getSummaryLine() {
	 	$summary = "Name: {$this->title}\n";
	 	$summary .= "Author: {$this->producerFirstName} {$this->producerLastName}\n";
	 	$summary .= "Price: {$this->price}\n";

	 	return $summary;
	}

	public static function getInstance($id, PDO $pdo) { // This would be used to create an object automatically aka factory
		$result = $pdo->query("SELECT * FROM products WHERE id='$id'");
		$product = $result->fetch(PDO::FETCH_ASSOC);

		if (empty($product)) {return null;}
		else {
			if ($product['type'] == 'book') {
			$item = new BookProduct(
				$product['title'],
				$product['producer_firstname'],
				$product['producer_lastname'],
				$product['price'],
				$product['number_of_pages']
			);
		} else if ($product['type'] == 'cd') {
			$item = new CdProduct(
				$product['title'],
				$product['producer_firstname'],
				$product['producer_lastname'],
				$product['price'],
				$product['play_length']
			);
		} else {
			$item = new ShopProduct(
				$product['title'],
				$product['producer_firstname'],
				$product['producer_lastname'],
				$product['price']
			);
		}  
	}

		$item->setID($product['id']);
		return $item;
	}
}

class BookProduct extends ShopProduct {
	protected $numOfPages;

	public function __construct($title, $producerFirstName, $producerLastName, $price, $numOfPages){
		parent::__construct($title, $producerFirstName, $producerLastName, $price);
		$this->numOfPages = $numOfPages;
	}

	public function getNumberOfPages() {
		return $this->numOfPages;
	}

	public function getBookSummary() {
		$summary = parent::getSummaryLine();
		$summary .= "Total pages: {$numOfPages}\n";
		return $summary;
	}
}

class CdProduct extends ShopProduct {
	protected $playLength;

	public function __construct($title, $producerFirstName, $producerLastName, $price, $playLength) {
		parent::__construct($title, $producerFirstName, $producerLastName, $price);
		$this->playLength = $playLength;
	}


	public function getPlayLength() {
		return $this->playLength;
	}

	public function getCdSummary() {
		$summary = parent::getSummaryLine();
		$summary .= "Duration: {$playLength}\n";
		return $summary;
	}
}

$classObject = new ReflectionClass('BookProduct');

echo "<pre>";
Reflection::export( $classObject ); // Provides more access to information (more like a summary) about classes in the system
echo "</pre>";

// Using more specific Reflection methods...

// We create a function to demonstrate a few more Reflection methods

function classData (ReflectionClass $class) {
	$details = "";
	$name = $class->getName();
	if ( $class->isUserDefined() ) {
		$details .= "$name is user defined\n";
	}

	if ( $class->isInternal() ) {
		$details .= "$name is built-in\n";
	}

	if ( $class->isInterface() ) {
		$details .= "$name is an interface\n";
	}

	if ( $class->isAbstract() ) {
		$details .= "$name is an abstract class\n";
	}

	if ( $class->isFinal() ) {
		$details .= "$name is final\n";
	}

	if ( $class->isInstantiable() ) {
		$details .= "$name can be instantiated\n";
	} else {
		$details .= "$name can not be instantiated\n";
	}

	if ( $class->isCloneable() ) {
		$details .= "$name can be cloned\n";
	} else {
		$details .= "$name can not be cloned\n";
	}

	return $details;
}


echo classData($classObject);

// ReflectionMethod is used to examine methods as ReflectionClass is used to examine classes

// To get the ReflectionMethod of each class method, use the ReflectionClass::getMethods() method which returna an array of all methods (ReflectionMethod objects) in the class...all that is left is to iterate through the array and use the desired ReflectionMethod object methods like...

// ReflectionMethod::getName()
// ReflectionMethod::isInternal()
// ReflectionMethod::isAbstract()
// ReflectionMethod::isPublic()
// ReflectionMethod::isProtected()
// ReflectionMethod::isPrivate()
// ReflectionMethod::isStatic()
// ReflectionMethod::isFinal()
// ReflectionMethod::isConstructor()


// Reflection API could also be used to access information on method arguments