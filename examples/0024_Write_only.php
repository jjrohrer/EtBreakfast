<?php

ini_set("display_errors","2");ERROR_REPORTING(E_ALL);
require_once(__DIR__.'/../config.php');


class SeasonalWave  {
    use EtLib18\RichData;

    function __construct() {
        $this->__construct_RichData_base(); # <!> This is important!
    }

    protected $__firstName = 'JJ'; // Underscore is short hand for read-only



}


print "RichData demo dies on write only shorthand";
$a = new SeasonalWave();
print "<br>first name via the 'getRaw', which always works: ".$a->getRaw('__firstName');
$a->__firstName = 'bob'; // this is ok cuz we are writing
print "<br>first name via the 'getRaw', which always works: ".$a->getRaw('__firstName');
print "<br> The first name is: ". $a->__firstName; // this dies cuz this a write only var

print "<pre><br>";
print_r($a);


