<?php

ini_set("display_errors","2");ERROR_REPORTING(E_ALL);
require_once(__DIR__.'/../config.php');


class SeasonalWave  {
    use EtLib18\RichData;

    function __construct() {
        $this->__construct_RichData_base();
    }

    protected $firstName = 'JJ';
    protected $lastName = 'Rohrer';
    protected $fullName; //<--- Just to be clear, we don't need the leading underscore
    function get_FullName() {
        return "{$this->firstName} {$this->lastName}";
    }



}


print "RichData demo";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName;
print "<br> The last name is: ". $a->lastName;
print "<br> The full name is: ". $a->fullName;  //<--- Q: Does this need to match your protected var?
print "<br> The full name with extra underscore is (expect an error here): ";
print $a->_fullName;  //<--- A: Yes, this throws an error


