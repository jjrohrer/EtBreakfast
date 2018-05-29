<?php

ini_set("display_errors","2");ERROR_REPORTING(E_ALL);
require_once(__DIR__.'/../config.php');


class SeasonalWave  {
    use EtLib18\RichData;

    function __construct() {
        $this->__construct_RichData_base(); # <!> This is important!
    }

    protected $firstName = 'JJ';
    protected $lastName = 'Rohrer';
    protected $_fullName;

// -- This would work... (but is confusing pretty everything else)
    function get_fullName() {
        return "{$this->firstName} {$this->lastName}";
    }

// --This would work... (but is confusing pretty everything else)
    function getfullName() {
        return "{$this->firstName} {$this->lastName}";
    }


    // -- This would work... (but is confusing pretty everything else)
    function _get_FullName() {
        return "{$this->firstName} {$this->lastName}";
    }

    // -- TThis would work... (but is confusing pretty everything else)
    function _getfullName() {
        return "{$this->firstName} {$this->lastName}";
    }

//    // -- This won't compile because standard PHP says this would conflict with _getfullName
//    function _getFullName() {
//        return "{$this->firstName} {$this->lastName}";
//    }




}


print "RichData demo.  This shows the ways it won't work (Please look at the the example source file to explanations)";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName; // (JJ) Magically gets firstName, even though it is protected:
print "<br> The last name is: ". $a->lastName;   // (Rohrer) Magically gets lastName, even though it is proectect
print "<br> The full name is: ". $a->_fullName;// (JJ Rohrer) Magically calls the getter for fullName

// $a->firstName = 'Bob';  // Error: cuz we haven't implemented setters yet, and firstName is protected
//print "<br> The full name is: ". $a->_fullName;// (Bob Rohrer) Magically calls the getter for fullName
//Next up:
// - Show the read-only working
