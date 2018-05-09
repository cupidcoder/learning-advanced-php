<?php
/************************************************************* Patterns for Flexible Object Programming / Structural / Organisation patterns ***********************************/

/*
*	Chapter covers:
*	The Composite pattern
*	The Decorator pattern
*	The Facade pattern
* 	(The design patterns here emphasize on th fact that composition ensures greater flexibility over inheritance)
*/

/*********** The Composite Pattern *************/

// The composite pattern relies heavily on inheritance by creating a tree-like hierarchy where the root class aggregates more special subclasses,
// that are indistinguishable to the client code. This allows for easy generation and traversal of tree objects.

// Problem: Managing groups of object that have close similarities but yet distinct, can be a difficult task.

/* 
	Imagine that we want to create a military game where units have bombard strength, addition and removal of units, following a system of multiple inheritance hierarchy can make things complex as we extend features.

	abstract class Unit {  						// First hierarchy
		abstract function bombardStrength();
	}

	class Archer extends Unit {
		function bombardStrength() {
			return 4;
		}
	}

	class Battalion extends Unit {
		function bombardStrength() {
			return 44;
		}
	}


	class Army {                              // Second hierarchy
		private $units = array();

		function addUnit(Unit $unit) {
			array_push($this->units, $unit);
		}

		function bombardStrength() {
			$totalStrength = 0;
			forEach($this->units as $unit) {
				$totalStrength += $unit->bombardStrength();
			}
			return $totalStrength;
		}
	}
	
	// Say we now want to add more methods to the unit class, we would need to also re-implement all methods in the child classes also
*/

// Implementation:

/*
	The composite pattern proposes that we maintain only one hierarchical inheritance

	abstract class Unit {
		abstract function addUnit();
		abstract function removeUnit();
		abstract function bombardStrength();
	}

	class Archer extends Unit {
		function addUnit() { 
			throw Exception(get_class($this) is a leaf class); // 
		}

		function removeUnit() { 
			throw Exception(get_class($this) is a leaf class); // 
		}

		function bombardStrength() {
			return 4;
		}
	}

	class Army extends Unit {
		private $units = array();

		function addUnit() { // Since the Army class aggregates Unit class, this method can be implemented
			... implement add unit method for Army child class
		}

		function removeUnit() {
			... implement add unit method for Army child class
		}

		function bombardStrength() {
			... implement add unit method for Army child class
		}
	}

	// For every leaf class, exceptions would have to be thrown for addUnit and removeUnit methods, therefore, throwing this exception in every leaf 
	// can become repetitive so it can be handled at the root class as shown below

	abstract class Unit {
		abstract function addUnit() { 
			throw Exception(get_class($this) is a leaf class); // 
		}

		abstract function removeUnit() { 
			throw Exception(get_class($this) is a leaf class); // 
		}

		abstract function bombardStrength();
	}

	// this however, has a side effect affecting child classes that aggregate the root class


*/

// Consequence: One drawback of the composite pattern is that, in some cases, the child classes might not need to implement the interfaces declared in the super class.
// One way to find a way around this is to create a child class that contains the interfaces that might be needed by composites

/*
	abstract class Unit {
		abstract function bombardStrength();

		public function getComposite() {
			return null;
		}
	}

	class CompositeUnit extends Unit {
		public function getComposite() {
			return $this;
		}

		public function addUnit() {
			... implement method
		}

		public function removeUnit() {
			... implement method
		}

		public function bombardStrength() {
			... implement method
		}
	}

	class Army extends CompositeUnit {
		... army specific implementation
	}

	
*/


/************* The Decorator pattern ****************/

// Problem:

// Relying solely on inheritance to pass down tasks can become inflexible.

// Implementation:
// In The decorator pattern, a child class down the inheritance hierarchy can hold an instantiation of the same class type. This allows for more flexibility. As shown below

/* 
	abstract class A {
		abstract function foo();
	}

	class FirstChild extends A {
		function foo () {
			// FirstChild's implementation
		}
	}

	class SecondChild extends A {
		function foo () {
			// SecondChild's implementation
		}
	}

	// to allow for greater flexibility down the inheritance hierachy

	abstract class DecoratorChild extends A {
		protected $class;

		function __construct (A $class) {
			$this->class = $class;
		}
	}

	class ThirdChildA extends DecoratorChild {
		function foo () {
			return $this->class->foo() . " plus this class's implementation"; // This allows for flexibility and a less coupled system.
		}
	} 

	class ThirdChildB extends DecoratorChild {
		function foo () {
		/	return $this->class->foo() . " plus this class's implementation" // This allows for flexibility and a less coupled system.
		}
	}
*/
	
// Consequences
// Like the Composite pattern, the decorator pattern can get a little confusing. As the inheritance hierarchy gets longer, child classes down the hierarchy may not 
// need methods passed on to them from their parents. 



/*********** The Facade Pattern **************/

// Problem: 
// When we need to fix in an external library or application into our system or simply create different modules in the same application, it can cause havoc to distribute
// the point of entries across multiple function/method calls

// Implementation: 
// The Facade pattern encourages us to use only one point of entry in this scenario