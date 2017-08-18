<?php

Route::group(['prefix' => config('hc.banner_prefix')], function () {
    Route::get('{id}', ['as' => 'ads.banner.show', 'uses' => 'banners\HCBannerShowController@show',]);
});