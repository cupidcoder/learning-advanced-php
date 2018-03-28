<?php
/************************************************************* Objects Basics ************************************************************/

/*
*	Chapter covers:
*	Classes and Objects: Declaring classes and instantiating objects
*	Constructor methods: Automating set-up of objects
*	Primitive and class types
*	Inheritance
*	Visibility
*/

/**************** Classes and Objects *************************/

// Definning classes

// This defines a class data type that can be used throughout the application
/*
class ShopProduct {

}
*/

// Instantiating Classes

// The class holds defines the data type (blueprint) while Objects hold the data
/*
$productOne = new ShopProduct();
$productTwo = new ShopProduct();

// Every object created is assigned a unique identifier by the PHP engine
var_dump($productOne); // displays -> object(ShopProduct)[1], 1 being the unique identifier
var_dump($productTwo); // displays -> object(ShopProduct)[2], 2 being the unique identifier

*/

// A property is a member variable of a class data type and it can hold different values from object to object

/*
class ShopProduct {
	public $title = "Default product"; // 'public' keyword means this property/member variable can be accessed from outside and within the class @PHP 5
	public $producerMainName = "main name";
	public $producerFirstName = "first name";
	public $price = 0;
}

*/

// Getting values (since it's public)
/*
print $productOne->title; // Prints "Default product"
echo "<br>";
print $productTwo->title;

// Setting values outside of class (because they are declared public)
$productOne->title = ""; // This is not considered good pratice
$productTwo->title = "Tunix: Create what you imagine";


print $productOne->title; // Prints nothing
echo "<br>";
print $productTwo->title; // Prints "Tunix: Create what you imagine";
*/


/**************** Few reasons why it is not good practice to set properties outside a class: **************************/

// It would become cumbersome to manually set properties for every class created

/*

$bookProduct = new ShopProduct();

$bookProduct->title = "My life";
$bookProduct->producerMainName = "Chukwudi";
$bookProduct->producerFirstName = "Umeilechukwu";
$bookProduct->price = 150;


var_dump($bookProduct); 
echo "<br>";

$cdProduct = new ShopProduct();

$cdProduct->title = "Advanced Warfare";
$cdProduct->producerMainName = "SledgeHammer";
$cdProduct->producerFirstName = "Games";
$cdProduct->price = 29;

var_dump($cdProduct);

echo "<br>";

*/

// It is error-prone to continuously set class properties outside class

/*

$cdProduct->titlee = "Title for wrong member variable"; // Mistakenly created a wrong class variable
$cdProduct->producerMainName = "Mr";
$cdProduct->producerFirstName = "Producer";
$cdProduct->price = 99;

var_dump($cdProduct);

echo "<br>";

*/

// It discourages client code from setting meaningful class properties upon instantiating


// Class methods
/*
class ShopProduct {
	public $title = "Default product"; // 'public' keyword means this property/member variable can be accessed from outside and within the class @PHP 5
	public $producerMainName = "main name";
	public $producerFirstName = "first name";
	public $price = 0;

	public function getProducer() {
		return "{$this->producerFirstName} {$this->producerMainName}";
	}
}

$gameProduct = new ShopProduct();

$gameProduct->title = "Tomb Raider";
$gameProduct->producerFirstName = "Konami";
$gameProduct->producerMainName = "Games";
$gameProduct->price = 199;

print $gameProduct->getProducer(); // Prints -> Konami Games

echo "<br>";


*/


// Creating a constructor method helps with instantiating an object with necessary configurations such as we did manually, above

/*

class ShopProduct {
	public $title;
	public $producerMainName;
	public $producerFirstName;
	public $price;

	public function __construct($title, $producerMainName, $producerFirstName, $price) { // Only for PHP 5 and upwards
		$this->title = $title;
		$this->producerMainName = $producerMainName;
		$this->producerFirstName = $producerFirstName;
		$this->price = $price;
	}

	public function getProducer() {
		return "{$this->producerFirstName} {$this->producerMainName}";
	}
}

$book = new ShopProduct('Php Beginner', 'Chuks', 'Dennins', 29.99); // This simplifies creating member variables for each object of ShopProduct instantiated

print "Producer name of Object: {$book->getProducer()}<br>";

$videoGame = new ShopProduct('PES', 'konami', 'Games', 19.99);

// var_dump($book);

// var_dump($videoGame);

print "Producer name of Object: {$videoGame->getProducer()}<br>";

*/

/********************* Argument and types **********************/

/*
*	It is important to handle the garbage that your code takes in form of arguments,
*	ensuring that the data type provided is in sync with what your code expects.
*	To handle this, you could adjust your code to modify the arg passed in,
*	use documentation for the method/function or force the client (code calling your method) to use the right data type your code needs
*/

// A sample class that check settings.xml if IP addresses should be resolved

// The challenge

/*
class AddressManager {
	private $addresses = array('192.0.6.21', '187.92.49.2'); // Not good practice for IP addresses should be hard-coded

	public function resolveAddress( $resolve ) {

		if ($resolve) {
			foreach ($this->addresses as $address) {
				echo "{$address}: Yes! <br>";
			}
		}
		
	}
}

$manager = new AddressManager();
$settings = simplexml_load_file("settings.xml");
$manager->resolveAddress((string) $settings->resolvedomains); // (string) $settings->resolvedomains would resolve to true since "false" is valid string

*/

// First solution 

// Ammend resolveAddress() method to check if argument passed in is a string and modify
/*
class AddressManager {
	private $addresses = array('192.0.6.21', '187.92.49.2'); // Not good practice for IP addresses to be hard-coded 

	public function resolveAddress( $resolve ) {

		if(is_string($resolve)) {
			$resolve = ( preg_match("/false|no|off/i", $resolve) ) ? false : true ; // Modifying the argument passed in, though not good practice because it makes the method more complex to use
		}

		if ($resolve) {
			foreach ($this->addresses as $address) {
				echo "{$address}: Yes! <br>";
			}
		}	
	}
}
*/


// Second Solution (this should really be used everytime)

// Use Documentation

// class AddressManager {
// 	private $addresses = array('192.0.6.21', '187.92.49.2'); // Not good practice for IP addresses should be hard-coded

/*
*	Outputs the list of addresses appended to "Yes"
*	if $resolve is true, then the addresses would be outputted
*	@param  $resolve boolean Resolve the address?
*/
// 	public function resolveAddress( $resolve ) {

// 		if ($resolve) {
// 			foreach ($this->addresses as $address) {
// 				echo "{$address}: Yes! <br>";
// 			}
// 		}	
// 	}
// }

// Third solution
// Force clients to use the right data type

/*

class AddressManager {
	private $addresses = array('192.0.6.21', '187.92.49.2'); // Not good practice for IP addresses should be hard-coded

	public function resolveAddress( $resolve ) {
		// first check if the passed in argument is a bool and exit the script if it's not
		if ( !is_bool( $resolve ) ) {
			die( "resolveAddress() requires boolean argument" ); // This ensures the resolveAddress() function focuses on its task and makes the method easy to understand
		}

		if ($resolve) {
			foreach ($this->addresses as $address) {
				echo "{$address}: Yes! <br>";
			}
		}
	}
}


$newManager = new AddressManager();

$settings = simplexml_load_file("settings.xml");

$newManager->resolveAddress($settings->resolvedomains); // -> "resolveAddress() requires boolean argument";

*/


// Argument hinting : Object type 
// Hinting on the data type that should be used by client code

/*
class ShopProduct {
	public $title = "Default product"; // 'public' keyword means this property/member variable can be accessed from outside and within the class @PHP 5
	public $producerMainName = "main name";
	public $producerFirstName = "first name";
	public $price = 0;

	public function __construct($title, $producerMainName, $producerFirstName, $price) { // Only for PHP 5 and upwards
		$this->title = $title;
		$this->producerMainName = $producerMainName;
		$this->producerFirstName = $producerFirstName;
		$this->price = $price;
	}

	public function getProducer() {
		return "{$this->producerFirstName} {$this->producerMainName}";
	}
}

class ShopProductWriter {
	public function writer( $ShopProduct ) { // Problem is you can't be certain that writer() would always receive an object
		$str = "Title: {$ShopProduct->title}\n";
		$str .= "{$ShopProduct->getProducer()} {$ShopProduct->price}";
		return $str;
	}
}

$foodProduct = new ShopProduct("Chicken", "Shop", "Rite", 3.99);

$writer = new ShopProductWriter();

print $writer->writer($foodProduct);

*/

// Improvising

/*
...
	public function writer( ShopProduct $ShopProduct) { // 
	// ...
	}

// same for arrays 

...
	public function writer( array $arrayVariable) { // 
	// ...
	}
*/

/********************* Inheritance **********************/

// Inheritance makes objects more powerful because it extends on the principle that every object should perform a single job
// keeping the complexity to the bearest minimum. 

/*
class ShopProduct {
	public $title;
	public $producerMainName;
	public $producerFirstName;
	public $price;
	public $numPages;
	public $playLength;

	public function __construct($title, $producerMainName, $producerFirstName, $price, $numPages = 0, $playLength = 0) { // Only for PHP 5 and upwards
		$this->title = $title;
		$this->producerMainName = $producerMainName;
		$this->producerFirstName = $producerFirstName;
		$this->price = $price;
		$this->numPages = $numPages;
		$this->playLength = $playLength;
	}

	public function getSummaryLine() {
		$summary = "Title: {$this->title}\n";
		$summary .= "Producer: {$this->producerMainName} {$this->producerFirstName}\n";
		$summary .= "Price: {$this->price}\n";
		return $summary;
	}
}

class CdProduct extends ShopProduct {
	public function getPlayLength () {
		return $this->playLength;
	}

	public function getSummaryLine(){
		$summary = "Title: {$this->title}\n";
		$summary .= "Producer: {$this->producerMainName} {$this->producerFirstName}\n";
		$summary .= "Duration: {$this->playLength}\n";
		$summary .= "Price: {$this->price}\n";
		return $summary;
	}
}


class BookProduct extends ShopProduct {
	public function getNumPages() {
		return $this->numPages;
	}
}

$book = new BookProduct("Harry Porter", "J . K", "Rowlings", "23.99", "1080");

print $book->getSummaryLine();

echo "<br>";

print $book->getNumPages();

var_dump($book);

$cd = new CdProduct("Superstar", "Wizkid", "Oludayo", "980", "", "45.06");

print $cd->getSummaryLine();

echo "<br>";

print $cd->getPlayLength();

var_dump($cd);

*/

// In the example above however, the base class (superclass) determines the properties of the children class

// Improvising using constructors for children classes

/*

class ShopProduct {
	public $title;
	public $producerMainName;
	public $producerFirstName;
	public $price;

	public function __construct($title, $producerMainName, $producerFirstName, $price, $numPages = 0, $playLength = 0) { // Only for PHP 5 and upwards @__construct
		$this->title = $title;
		$this->producerMainName = $producerMainName;
		$this->producerFirstName = $producerFirstName;
		$this->price = $price;
	}

	public function getSummaryLine() {
		$summary = "Title: {$this->title}\n";
		$summary .= "Producer: {$this->producerMainName} {$this->producerFirstName}\n";
		$summary .= "Price: {$this->price}\n";
		return $summary;
	}
}

class CdProduct extends ShopProduct {
	public $playLength;
	function __construct ($title, $producerMainName, $producerFirstName, $price, $playLength) {
		parent::__construct($title, $producerMainName, $producerFirstName, $price);
		$this->playLength = $playLength;
	}

	public function getPlayLength() {
		return $this->playLength;
	}

	public function getSummaryLine() {
		$summary = "Title: {$this->title}\n";
		$summary .= "Producer: {$this->producerMainName} {$this->producerFirstName}\n";
		$summary .= "Duration: {$this->playLength}\n";
		$summary .= "Price: {$this->price}\n";
		return $summary;
	}
}


class BookProduct extends ShopProduct {
	public $numPages;

	function __construct ($title, $producerMainName, $producerFirstName, $price, $numPages){
		parent::__construct($title, $producerMainName, $producerFirstName, $price);
		$this->numPages = $numPages;
	}
	public function getNumPages() {
		return $this->numPages;
	}

	public function getSummaryLine() {
		$summary = parent::getSummaryLine(); // Overriding the parent method
		$summary .= "No of Pages: {$this->numPages}\n";
		return $summary;
	}
}

$book = new BookProduct("Harry Porter", "J . K", "Rowlings", "23.99", "1080");

print $book->getSummaryLine();

echo "<br>";

print $book->getNumPages();

var_dump($book);

$cd = new CdProduct("Superstar", "Wizkid", "Oludayo", "980", "45.06");

print $cd->getSummaryLine();

echo "<br>";

print $cd->getPlayLength();

var_dump($cd);

*/

/*************** Visibility ****************/
// public function/variable -> modifiable and accessible from outside the current instance and child classes
// protected function/variable -> modifiable and accessible from within the current instance and child classes
// private function/variable -> modifiable and accessible from within the current instance alone, excluding child classes


// -- General rule of thumb --
// Any property or method that is used only by methods in the class should be set to private/protected
