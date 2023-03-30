<?php

namespace Supermetrics\Ambassador\Drivers;

interface Driver
{
    public function store();

    public function findById();
}
