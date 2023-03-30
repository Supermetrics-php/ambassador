<?php

use PHPUnit\Framework\TestCase;
use Supermetrics\Ambassador\Ambassador;

class AmbassadorTest extends TestCase
{
    public function testIfAmbassadorCanCreateDriver()
    {
        $ambassador = new Ambassador('mysql');
        var_dump($ambassador->handle([]));
    }
}
