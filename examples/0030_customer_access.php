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
    protected $fullName;
    // There is no way we could infer that this method is the one we want, so we'll specify it explicitly
    function determineRealName() { return "{$this->firstName} {$this->lastName}";    }

    CONST fullName_getBy = 'determineRealName';
        // (1) use CONST
        // (2) use the _exactly_ var name, and suffix it with '_getBy' or '_setBy'
        // (3) assign it to the name of the method to call



}


print "RichData demo";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName;
print "<br> The last name is: ". $a->lastName;
print "<br> The full name is: ". $a->fullName;  //<--- This calls $this->determineRealName

print "<pre><br>";
print_r($a);

