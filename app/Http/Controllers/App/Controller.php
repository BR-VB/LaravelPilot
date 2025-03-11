<?php

namespace App\Http\Controllers\App;

abstract class Controller
{
    protected string $className;

    public function __construct()
    {
        $this->className = class_basename(static::class);
    }
}
