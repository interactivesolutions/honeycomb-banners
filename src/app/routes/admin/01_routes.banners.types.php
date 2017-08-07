<?php

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
