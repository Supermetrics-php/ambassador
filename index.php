<?php
require_once 'vendor/autoload.php';

use Supermetrics\Ambassador\Ambassador;

$ambassador = new Ambassador('redis');

//var_dump($ambassador->fetchById('users', '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8'));
//var_dump($ambassador->persist('users', [
//    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', 'name' => 'farshid'],
//    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d9', 'name' => 'mary']
//]));

var_dump($ambassador->fetchAll('users'));
