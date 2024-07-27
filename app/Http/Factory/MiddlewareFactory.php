<?php

namespace App\Http\Factory;

use App\Http\Middleware\OffRequestMiddleware;

class MiddlewareFactory
{
    public static function createOffRequestMiddleware()
    {
        return new OffRequestMiddleware();
    }
}
