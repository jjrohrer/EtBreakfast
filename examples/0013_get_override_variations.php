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
    protected $_fullName2;
    protected $_fullName3;
    protected $_fullName4;
    protected $_fullName5;
    protected $_fullName6;
    protected $_fullName7;
    protected $_fullName8;

// -- This works...
    function get_fullName() {
        return "{$this->firstName} {$this->lastName}";
    }

// -- This works... (no underscore)
    function getfullName2() {
        return "{$this->firstName} {$this->lastName} v2";
    }

    // -- This works... (first letter uppercased)
    function getFullName3() {
        return "{$this->firstName} {$this->lastName} v3";
    }
    // -- This works... (first letter uppercased and still with underscore)
    function get_FullName4() {
        return "{$this->firstName} {$this->lastName} v4";
    }
    // -- This works... (first letter uppercased and still with underscore)
    function _get_FullName5() {
        return "{$this->firstName} {$this->lastName} v5";
    }
    // -- This works... (first letter uppercased and still with underscore)
    function _get_fullName6() {
        return "{$this->firstName} {$this->lastName} v6";
    }
    // -- This works... (first letter uppercased and still with underscore)
    function _getfullName7() {
        return "{$this->firstName} {$this->lastName} v7";
    }
    // -- This works... (first letter uppercased and still with underscore)
    function _getFullName8() {
        return "{$this->firstName} {$this->lastName} v8";
    }




}


print "RichData demo (Please look at the the example source file to explanations)";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName; // (JJ) Magically gets firstName, even though it is protected:
print "<br> The last name is: ". $a->lastName;   // (Rohrer) Magically gets lastName, even though it is proectect
print "<br> The full name is: ". $a->_fullName;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is2: ". $a->_fullName2;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is3: ". $a->_fullName3;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is4: ". $a->_fullName4;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is5: ". $a->_fullName5;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is6: ". $a->_fullName6;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is7: ". $a->_fullName7;// (JJ Rohrer) Magically calls the getter for fullName
print "<br> The full name is8: ". $a->_fullName8;// (JJ Rohrer) Magically calls the getter for fullName

// $a->firstName = 'Bob';  // Error: cuz we haven't implemented setters yet, and firstName is protected
//print "<br> The full name is: ". $a->_fullName;// (Bob Rohrer) Magically calls the getter for fullName
//Next up:
// - Show the read-only working

