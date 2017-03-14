<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*require __DIR__ . '/routes_api.php';
require __DIR__ . '/routes_wap.php';
require __DIR__ . '/routes_admin.php';
require __DIR__ . '/routes_pc.php';*/
require_once(app_path() . '/' . 'Http/routes_admin.php');

