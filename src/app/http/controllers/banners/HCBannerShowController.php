<?php

namespace interactivesolutions\honeycombbanners\app\http\controllers\banners;

use Cache;
use DB;
use interactivesolutions\honeycombbanners\app\http\BannersHelper;
use interactivesolutions\honeycombbanners\app\models\HCBanners;
use interactivesolutions\honeycombcore\http\controllers\HCBaseController;

class HCBannerShowController extends HCBaseController
{
    /**
     * Banner shows recording
     *
     * @param $id
     * @param BannersHelper $helper
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function show($id, BannersHelper $helper)
    {
        $key = 'banner_show_' . $id;

        // if banner view is cached
        if( Cache::has($key) ) {
            // increment shows
            DB::table(HCBanners::getTableName())->where('id', $id)->increment('shows');

            return Cache::get($key);
        }

        $item = HCBanners::with('banner_type')->has('banner_type')->find($id);

        $html = '';

        if( $item ) {
            $html = $helper->getBannerHtml($item);

            $item->increment('shows');

            // add to cache all view
            $response = (hcview('HCBanners::show', ['html' => $html])->render());

            Cache::put($key, $response, 10);

            return $response;
        }

        return hcview('HCBanners::show', ['html' => $html]);
    }
}