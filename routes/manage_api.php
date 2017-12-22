<?php

$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| Manage API Routes
|--------------------------------------------------------------------------
*/


$api->version('v1', ['prefix' => '/api/manage', 'namespace' => 'App\Api\Controllers\Manage'], function ($api) {
    #
    $api->group(['namespace' => 'User'], function ($api) {
        $api->post('login', 'CommonController@login');
    });
    $api->group(['namespace' => 'Home'], function ($api) {
        $api->post('upload', 'CommonController@upload');
    });

    # Login
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        # User
        $api->group(['namespace' => 'User'], function ($api) {
            $api->get('token_refresh','CommonController@tokenRefresh');
            # /manage/user
            $api->group(['prefix' => 'user'], function ($api) {
                $api->resource('member', 'MemberController');
                $api->patch('member/{id}/block', 'MemberController@upBlock');

                # Partner
                $api->resource('partner', 'PartnerController');
                $api->patch('partner/{id}/block', 'PartnerController@upBlock');

                # User Info
                $api->get('info', 'CommonController@info');

            });
        });

        # Home
        $api->group(['namespace' => 'Home'], function ($api) {
            $api->get('menus', 'CommonController@menus');
            $api->get('map_key', 'CommonController@mapKey');
            # set global argument
            $api->get('argument', 'CommonController@getArgu');
            $api->put('argument', 'CommonController@setArgu');


            # /manage/home
            $api->group(['prefix' => 'home'], function ($api) {
                $api->get('menu', 'MenuController@lists');

                $api->resource('banner', 'BannerController');
                $api->patch('banner/{id}/show', 'BannerController@upShow');

            });


        });







    });

});
