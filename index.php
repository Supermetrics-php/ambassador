<?php
require_once 'vendor/autoload.php';

use Supermetrics\Ambassador\Ambassador;

$ambassador = new Ambassador('mysql');

var_dump($ambassador->handle(['yd' => 'asdas']));
