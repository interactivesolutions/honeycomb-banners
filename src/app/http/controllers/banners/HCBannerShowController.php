<?php

namespace interactivesolutions\honeycombbanners\app\http\controllers\banners;

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
        $item = HCBanners::with('banner_type')->has('banner_type')->find($id);

        $html = '';

        if( $item ) {
            $html = $helper->getBannerHtml($item);

            $item->increment('shows');
        }

        return hcview('HCBanners::show', ['html' => $html]);
    }
}
