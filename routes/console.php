<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:create', function () {
    $this->comment('User created');
    $user = new \App\Models\User();
    $user->name = 'Alberto Sanchez';
    $user->email = 'alberroteran@gmail.com';
    $user->password = \Illuminate\Support\Facades\Hash::make('.bet0.1103.');
    $user->save();
})->purpose('Create a new user');
