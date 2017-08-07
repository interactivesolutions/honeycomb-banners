<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/banners'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.banners', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_create'], 'uses' => 'HCBannersController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.banners.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.banners.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.banners.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.banners.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_create', 'acl-apps:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.banners.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_force_delete'], 'uses' => 'HCBannersController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.banners.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.banners.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.banners.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_list', 'acl-apps:interactivesolutions_honeycomb_banners_routes_banners_create'], 'uses' => 'HCBannersController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.banners.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_force_delete'], 'uses' => 'HCBannersController@apiForceDelete']);
        });
    });
});