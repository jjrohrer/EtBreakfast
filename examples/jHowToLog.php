<?php
require_once ('../config.php');
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

global $logger;
$logger->addInfo('Hello log!');
$logger->error('Bar');
print "<br>HW"; // This will still show up