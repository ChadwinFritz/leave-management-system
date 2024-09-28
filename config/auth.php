<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'admin'), // Changed default to 'admin'
        'passwords' => env('AUTH_PASSWORD_BROKER', 'admins'), // Changed default to 'admins'
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | A great default configuration has been defined for you which utilizes
    | session storage plus the Eloquent user provider.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'admin' => [ // Admin guard
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'employee' => [ // Employee guard (if separate)
            'driver' => 'session',
            'provider' => 'employees', // Adjusted for employee provider
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a provider, which defines how the admins
    | are actually retrieved from your database or other storage system used
    | by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple admin tables or models, you may configure multiple
    | providers to represent the model/table.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'admins' => [ // Admin provider
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class, // Changed to Admin model
        ],

        'employees' => [ // Employee provider (if you have a separate Employee model)
            'driver' => 'eloquent',
            'model' => App\Models\Employee::class, // Adjusted for Employee model
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. You may change this as needed.
    |
    */

    'passwords' => [
        'admins' => [ // Admin password reset configuration
            'provider' => 'admins',
            'table' => 'password_reset_tokens', // Same table for simplicity
            'expire' => 60,
            'throttle' => 60,
        ],

        'employees' => [ // Employee password reset configuration (if needed)
            'provider' => 'employees',
            'table' => 'password_reset_tokens', // Same table for simplicity
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and admins are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
