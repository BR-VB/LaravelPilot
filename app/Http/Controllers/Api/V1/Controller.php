<?php

namespace App\Http\Controllers\Api\V1;

abstract class Controller
{
    protected string $className;
    protected string $apiLocale;

    public function __construct()
    {
        $this->className = "api/" . class_basename(static::class);
        $this->apiLocale = session('apiLocale') ?? config('app.locale');
    }
}
