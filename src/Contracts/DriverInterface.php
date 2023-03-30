<?php

namespace Supermetrics\Ambassador\Contracts;

interface DriverInterface
{
    public function store();

    public function findById();
}
