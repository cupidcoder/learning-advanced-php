<?php
/************************************************************* Good (and Bad) Practice ************************************************************/

/*
*	Chapter covers, by overviewing the things that will be  covered in subsequent chapters:
*	Third-party packages: Where to get them, when to use them
*	Build: Creating and deploying packages
*	Version control: Bringing harmony to the development process
*	Documentation: Writing code that is easy to understand, use, and extend
*	Unit testing: A tool for automated bug detection and prevention
*	Continuous integration: Using this practice and set of tools to automate project builds and tests and be alerted of problems as they occur
*/

/********** Third-party packages ****************/

/*
* Reinventing the wheel can be time-consuming, ineffective and an impediment to the agile development process. Where possible and necessary, using third-party packages 
* for some utility functions like form handling, and a bunch of other mundane tasks that have already been accomplished by developers before. 
* It is good practice to first check if a package exists, whether is suites your needs and if it can be ammendable before reinventing the wheel. More focus should be on 
* delivering the business logic
*/



/********** Build ****************/

/*
* After necessary testing, deployment can become a chore. Buid tools help with getting required files and installation.
*/

/********** Documentation ****************/

/*
* Documentation helps us and also future developers that would work on the project. Code documentation tools like PHPDoc can generate documents, web pages 
* stating function/method arguments, samples and return types and also hyper-linking code references.
*/

/********** Unit testing ****************/

/*
* Writing tests can be a chore but the true reward pays off when the codebase evolves to a mammoth and changes in the system causes a ripple of errors in other 
* interrelated classes. With a test suite in place, all tests can be run after changes are made to ensure that code written elsewhere doesn't break
*/

/********** Continuous integration ****************/

/*
* Some tasks in software development can be repetitive and mundane. And one of the tenets in software development is to not Repeat yourself. This can be 
* extended outside code to tasks like building, building and building after every test and code check in. Continuous integration tools help alleviate this chore from your 
* desks.
*/