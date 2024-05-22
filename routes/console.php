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
if (App::environment() != 'local') {
    Artisan::command('migrate:fresh', function () {
        $this->comment("This is only allowed in dev env...");
    })->purpose('Prevent this action');

    Artisan::command('migrate:reset', function () {
        $this->comment("This is only allowed in dev env...");
    })->purpose('Prevent this action');

    Artisan::command('migrate:rollback', function () {
        $this->comment("This is only allowed in dev env...");
    })->purpose('Prevent this action');
}
