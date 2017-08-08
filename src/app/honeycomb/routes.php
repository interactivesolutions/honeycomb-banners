<?php

//src/app/routes//admin/01_routes.banners.types.php


Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('banners/types', ['as' => 'admin.routes.banners.types.index', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@adminIndex']);

    Route::group(['prefix' => 'api/banners/types'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.banners.types', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_create'], 'uses' => 'banners\\HCBannerTypesController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.banners.types.list', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.banners.types.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.banners.types.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_create', 'acl:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.banners.types.force', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_force_delete'], 'uses' => 'banners\\HCBannerTypesController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.banners.types.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.banners.types.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.banners.types.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_list', 'acl:interactivesolutions_honeycomb_banners_routes_banners_types_create'], 'uses' => 'banners\\HCBannerTypesController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.banners.types.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_banners_routes_banners_types_force_delete'], 'uses' => 'banners\\HCBannerTypesController@apiForceDelete']);
        });
    });
});


//src/app/routes//admin/02_routes.banners.php


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


//src/app/routes//api/01_routes.banners.types.php


Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/banners/types'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.banners.types', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_create'], 'uses' => 'banners\\HCBannerTypesController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.banners.types.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.banners.types.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.banners.types.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.banners.types.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_create', 'acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.banners.types.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_force_delete'], 'uses' => 'banners\\HCBannerTypesController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.banners.types.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_list'], 'uses' => 'banners\\HCBannerTypesController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_delete'], 'uses' => 'banners\\HCBannerTypesController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.banners.types.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_update'], 'uses' => 'banners\\HCBannerTypesController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.banners.types.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_list', 'acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_create'], 'uses' => 'banners\\HCBannerTypesController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.banners.types.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_banners_routes_banners_types_force_delete'], 'uses' => 'banners\\HCBannerTypesController@apiForceDelete']);
        });
    });
});

//src/app/routes//api/02_routes.banners.php


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

//src/app/routes//public/01_routes.banner.shows.php


Route::group(['prefix' => 'ads/banner'], function () {
    Route::get('{id}', ['as' => 'ads.banner.show', 'uses' => 'banners\HCBannerShowController@show',]);
});
