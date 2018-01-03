<?php


$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



$api->version('v1', ['prefix' => '/api', 'namespace' => 'App\Api\Mobile\Controllers'], function ($api) {

    $api->get('banner', 'BannerController@index');
    $api->get('index', 'IndexController@index');
    $api->post('member', 'MemberController@info');
    $api->get('info/{id}', 'IndexController@info');
    $api->get('banner/info', 'BannerController@info');
    $api->get('plotMembers', 'IndexController@plotMembers');
    $api->post('receiveMsg', 'IndexController@receiveMsg');
    $api->get('sendMsg', 'IndexController@sendMsg');
    $api->get('uploadMaterial', 'IndexController@uploadMaterial');

});