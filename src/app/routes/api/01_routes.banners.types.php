<?php

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