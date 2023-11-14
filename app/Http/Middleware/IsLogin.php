<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\IsLogin as Middleware;

class IsLogin extends Middleware
{
    public function __construct()
    {
        echo "middleware";
    }
}
