<?php

Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('banners', ['as' => 'admin.routes.banners.index', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@adminIndex']);

    Route::group(['prefix' => 'api/banners'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.banners', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_create'], 'uses' => 'HCBannersController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.banners.list', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.banners.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.banners.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_create', 'acl:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.banners.force', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_force_delete'], 'uses' => 'HCBannersController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.banners.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_list'], 'uses' => 'HCBannersController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_delete'], 'uses' => 'HCBannersController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.banners.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_update'], 'uses' => 'HCBannersController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.banners.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_list', 'acl:interactivesolutions_honeycomb_banners_routes_banners_create'], 'uses' => 'HCBannersController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.banners.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_force_delete'], 'uses' => 'HCBannersController@apiForceDelete']);
        });
    });
});
