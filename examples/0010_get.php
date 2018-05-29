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
    function get_FullName() {
        return "{$this->firstName} {$this->lastName}";
    }



}


print "RichData demo";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName; // (JJ) Magically gets firstName, even though it is protected:
print "<br> The last name is: ". $a->lastName;   // (Rohrer) Magically gets lastName, even though it is proectect
print "<br> The full name is: ". $a->_fullName;// (JJ Rohrer) Magically calls the getter for fullName

// $a->firstName = 'Bob';  // Error: cuz we haven't implemented setters yet
//print "<br> The full name is: ". $a->_fullName;// (Bob Rohrer) Magically calls the getter for fullName
//Next up:
// - Show the read-only working

