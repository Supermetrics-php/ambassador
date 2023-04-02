<?php
require_once 'vendor/autoload.php';

use Supermetrics\Ambassador\Ambassador;

//$ambassador = new Ambassador('file');
$ambassador = new Ambassador('mysql');

//$result = $ambassador->persist('users', [
//    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', 'name' => 'farshid'],
//    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d9', 'name' => 'mary'],
//    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0a8', 'name' => 'farshid'],
//]);

$result = $ambassador->fetchById('users', '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8');
//$result = $ambassador->fetchAll('users');

var_dump($result);
