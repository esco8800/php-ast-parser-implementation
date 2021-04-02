<?php

use classes\Generator;

require 'vendor/autoload.php';
ini_set ( 'xdebug.max_nesting_level' , 3000 );

$generator = new Generator();
$generator->run();