<?php

Route::group(['prefix' => 'ads/banner'], function () {
    Route::get('{id}', ['as' => 'ads.banner.show', 'uses' => 'banners\HCBannerShowController@show',]);
});