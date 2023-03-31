<?php
require_once 'vendor/autoload.php';

use Supermetrics\Ambassador\Ambassador;

$ambassador = new Ambassador('mysql');

var_dump($ambassador->persist('users', [
    ['id' => '111', 'name' => 'farshid'],
    ['id' => '111', 'name' => 'farshid']
]));
