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
            if( $item->type == 'image' ) {
                $html = $helper->imageTpl(
                    route('resource.get', $item->resource_id), $item->banner_type->width, $item->banner_type->height
                );
            } else if( $item->type == 'zip' ) {
                $html = $helper->iFrameTpl(
                    $helper->getIFrameLink($item), $item->banner_type->width, $item->banner_type->height
                );
            }

            $item->increment('shows');
        }

        return hcview('HCBanners::show', ['html' => $html]);
    }
}
