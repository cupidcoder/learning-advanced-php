<?php
/************************************************************* Objects History ************************************************************/

/* 
* Drawbacks of Objects in PHP 4 and below
*/

// Re-ssigning an Object to a variable, returning from a function 
// and passing it to a function resulted in "assignment by value"
// instead of a "assignment by reference"

class Reference {
	private $testVariable;
}

// In PHP 4
// Issue
$object = new Reference(); // Assignment by reference maintaining link to the Reference class

$newObject = $object; // Assignment by value, creating a copy on $object object and new methods/modifications on $object will not be captured in $newObject

// Hot Fixx 
$value =& $reference; // This was resolved by appending the ampersand symbol to the front of the object;


/***************************************************************************************************************************************************/

/*
* PHP 5 championed Objects in PHP's history
*/

// Assignment by value was fixed, namespaces and a host of other features were introduced

