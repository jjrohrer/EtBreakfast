<?php

ini_set("display_errors","2");ERROR_REPORTING(E_ALL);
require_once(__DIR__.'/../config.php');


class SeasonalWave  {
    use EtLib18\RichData;

    function __construct() {
        $this->__construct_RichData_base(); # <!> This is important!
    }

    protected $firstName = 'JJ';



}


print "RichData demo";
$a = new SeasonalWave();
print "<br> The first name is: ". $a->firstName;
$a->firstName = 'bob';
print "<br>First name is ".$a->firstName;

print "<pre><br>";
print_r($a);


