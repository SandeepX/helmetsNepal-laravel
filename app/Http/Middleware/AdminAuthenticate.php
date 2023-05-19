<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends Middleware
{

    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return route('admin.login')->withInput()->withErrors(['login_error' => 'Please Login First ']);
        }
        return route('admin.login');
    }
}
