<?php
/************************************************************* Advanced Feautres ************************************************************/
/*
*	Chapter covers:
*	Static methods and properties: Accessing data and functionality through classes rather than objects
*	Abstract classes and interfaces: Separating design from implementation
*	Traits: Sharing implementation between class hierarchies
*	Error handling: Introducing exceptions
*	Final classes and methods: Limiting inheritance
*	Interceptor methods: Automating delegation
*	Destructor methods: Cleaning up after your objects
*	Cloning objects: Making object copies
*	Resolving objects to strings: Creating a summary method
*	Callbacks: Adding functionality to components with anonymous functions
*/

/*************** Static methods and properties: Accessing data and functionality through classes rather than objects ***********************/
/*
class StaticExample {
	static public $varOne = 1; // @static is available in PHP 5+
	static public function sayHello() {
		print "Hello you<br>";
	}
}

echo StaticExample::$varOne . "<br>"; // :: is used to access class properties/methods rather than instances(objects) of them (classes)
StaticExample::sayHello();

class StaticExample {
	static public $varOne = 1; // @static is available in PHP 5+
	static public function sayHello() {
		print "Hello you<br>";
	}

	static public function triggerSayHello(){
		return self::sayHello(); // Self is used to access static properties/methods from within the class
	}
}

StaticExample::triggerSayHello();

*/

/****************** Demonstrating the usefulness of static properties/methods using sqlite RDMS *************************/
/*
$dsn = "sqlite:" . dirname(__FILE__) . "/chapterFour.db";

$pdo = new PDO($dsn, null, null);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
	$pdo->exec(
		"CREATE TABLE IF NOT EXISTS products(
		id INT NOT NULL,
		type VARCHAR(10),
		title VARCHAR(30),
		producer_firstname VARCHAR(30),
		producer_lastname VARCHAR(30),
		price INT,
		play_length VARCHAR(8),
		number_of_pages INT,
		PRIMARY KEY(id))"
	);
} catch (PDOEXCEPTION $e) {
	$msg = "Error: " . strtoupper($e->getMessage()) . ", while creating table";
	echo $msg;
	exit();
}

$pdo = null; // Kill database connection
*/
// $pdo->exec("
// 	INSERT INTO products(id, type, title, producer_firstname, producer_lastname, price, play_length, number_of_pages) 
// 	VALUES('1', 'book', 'Advanced Warfare', 'Slegde', 'games', '29.99', '', '280'), ('2', 'cd', 'Superstar', 'Chukwudi', 'Umeh', '35.49', '45:90', ''), ('3', 'book', 'Quiet: Power of Introvert', 'Susain', 'Cain', '34.99', '', '560')");

/*

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

*/

// $pdo = new PDO($dsn, null, null);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $obj = ShopProduct::getInstance(3, $pdo);

// var_dump($obj);


/******************* Constant Properties ***********************/

/*
class ShopProduct {
	const AVAILABLE = 0; // Constant properties are used to define never changing variables for classes that should be available to all instances
	const OUT_OF_STOCK = 1;
	//.. 
}

*/
/******************* Abstract methods ***********************/

// Abstract classes can't be instantiated as they only provide a base for other classes to be built upon
// Abstract methods allow for child classes to implement their methods - by declaring the methods but ensuring  that child classes would implement the methods

/*

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

	public function getTitle() {
		return $this->title;
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
		try {
			$result = $pdo->query("SELECT * FROM products WHERE id='$id'");
		} catch (PDOEXCEPTION $e) {
			$msg = "Error: " . $e->getLine() . ", while performing query";
			echo $msg;
			exit();
		}
		
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

	public function getSummaryLine() {
		$summary = parent::getSummaryLine();
		$summary .= "Total pages: {$this->numOfPages}\n";
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

	public function getSummaryLine() {
		$summary = parent::getSummaryLine();
		$summary .= "Duration: {$this->playLength}\n";
		return $summary;
	}
}

abstract class ShopProductWriter {
	protected $products = array();

	public function setProduct(ShopProduct $shopProduct) {
		$this->products[] = $shopProduct;
	}

	abstract public function write();
}

// Different implementations of ShopProductWriter

class XmlProductWriter extends ShopProductWriter {
	
	public function write() {
		$writer = new XMLWriter();
		$writer -> openMemory();
		$writer -> startDocument('1.0', 'UTF-8');
		$writer -> startElement("products");
		foreach ($this->products as $product) {
			$writer -> startElement("product");
			$writer -> writeElement("title", $product -> getTitle() );
			$writer -> startElement("summary");
			$writer -> text( $product -> getSummaryLine() );
			$writer -> endElement(); // summary element
			$writer -> endElement(); // product element		
		}

		$writer -> endElement(); // products (root element)
		$writer -> endDocument(); 
		print $writer -> flush();
	}

}

class TextProductWriter extends ShopProductWriter {
	public function write() {
		$text = "PRODUCTS:\n";
		foreach ($this->products as $product) {
			$text .= $product -> getSummaryLine() . "\n";
		}
		print $text;
	}
}


// Shopproduct object factored from db
$dsn = "sqlite:" . dirname(__FILE__) . "/chapterFour.db";
$pdo = new PDO($dsn, null, null);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$obj = ShopProduct::getInstance(2, $pdo);


// xml objects
$xmlShopProductWriter = new XmlProductWriter();

$xmlShopProductWriter -> setProduct($obj);

$xmlShopProductWriter -> write(); // xml implementation of write() method

$textShopProductWriter = new TextProductWriter();

$textShopProductWriter -> setProduct($obj);

$textShopProductWriter -> write(); // text implementation of write() method


*/

/******************* Interfaces ***********************/

// Interfaces only acts as pure templates - they can't act like classes

/*

interface Chargeable {
	// private $testVariable; // -> error: Interfaces may not include member variables in C:\wamp64\www\learning-advanced-php\chapterFour\AdvancedFeatures.php on line 386

	public function testFunction();
}


// Implemented below as: 

class ShopProduct implements Chargeable {
	public function testFunction() {
		// Function code goes here
	}
}

*/


/******************* Handling Errors ***********************/

// It is important to handle unexpected events in your code to manage the buggy behaviour your application
// Handling errors basically mean taking over the language's inbuilt ugly error handling
/*
class Conf {
	protected $file;
	protected $xml;
	protected $lastMatch;

	public function __construct($file) {
		$this->file = $file;
		$this->xml = simplexml_load_file($file);
	}

	public function write() {
		file_put_contents($this->file, $this->xml->asXML());
	}

	public function get($str) {
		$matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
		if ( count( $matches ) ) {
			$this->lastMatch = $matches[0];
			return (string)$matches[0];
		}
		return null;
	}

	public function set( $key , $value) {
		if ( ! is_null( $this->get($key) ) ) {
			$this->lastMatch[0] = $value;
			return;
			$conf = $this->xml->conf;
			$this->xml->addChild('item', $value) -> addAttribute('name', $key);
		}
	}
}

*/



// Subclassing the Exception class can be a powerful way to extend the functionality of catching errors. 

/*
 class FirstException extends Exception {
	// does nothing but only subclasses
 }

 class SecondException extends Exception {
	// Does nothing again but only subclasses
 }

 */
// client code

 /*
	try {
		// does something
	} catch (FirstException $e) {
		// catches First exception
	} catch (SecondException $e) {
		// catches Second exception
	}
*/

// finally clause allows for a default action to always be taken whether or not an exception is thrown

/*
	//...
	finally {
		// default action
	}
*/

// Issues with the class above could result in a number of unexpected behaviours as we are not sure whether the $file provided to the constructor
// is not broken, the xml file is provided is valid and so on


/***************** Traits *************************/



/***************** Exceptions *************************/
// Exceptions are a neat way to handle errors because it makes it possible for you to control what the app does in the event of error, 
// and also providing error and debugging information for further investigations

// Throwing an Exception

// The __construct method and write methods could be adjusted to handle errors better:

/*


... 

public function __construct($file) {
		$this->file = $file;
		if ( ! is_file($file) ) {
			throw new Exception ("File" . $file . ", does not exist!"); // This would be the result of  getMessage() if error is triggered in client code
		}
		$this->xml = simplexml_load_file($file);
	}
...


public function write() {
	if ( ! is_writeable($this->file) ) {
		throw new Exception ("File" . $this->file . ", is not writeable");
	} file_put_contents($this->file, $this-xml->asXML());	
}


/***************** Try and Catch *************************/
// Wrapping your code around a try block enables you to catch the exceptions thrown 
/*
Handling exceptions thrown above

try {
	$config = new Conf();
	$config -> set("play.xml");
	$config -> write();

} catch (EXCEPTION $e) {
	die ( $e->getMessage() );
}

*/


/***************** Extending the EXCEPTION classes / Subclassing Exceptions *******************/

// This allows us to add more functionalities and build upon the Exception class:
// One advantage is adding different exceptions for handling different cases




/***************** Finally clause after an exception **********************/

// A finally block specifies what always happens regardless of whether an exception was thrown or not


/***************** Final class/method *************************/

// A final class cannot be extended and a final method cannot be overwritten





/***************************** Interceptors ****************************************/
// interceptors below allow us set default actions for properties/method not defined in our class

// __call(), __toString() , __get() , __set() , __destruct() , __isset(), __unset() 





