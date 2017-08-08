<?php

namespace interactivesolutions\honeycombbanners\app\http;

class BannersHelper
{
    /**
     * Image html tpl
     *
     * @param $src
     * @param $width
     * @param $height
     * @return string
     */
    public function imageTpl($src, $width, $height)
    {
        return sprintf("<img src='%s' width='%s' height='%s'>", $src, $width, $height);
    }

    /**
     * iFrame tpl
     *
     * @param $src
     * @param $width
     * @param $height
     * @return string
     */
    public function iFrameTpl($src, $width, $height)
    {
        return sprintf("<iframe src='%s' border='0' scrolling='no' width='%s' height='%s' style='border:0;'></iframe>", $src, $width, $height);
    }

    /**
     * Get iFrame link
     *
     * @param $banner
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getIFrameLink($banner)
    {
        return url(
            sprintf('storage/banners/%s', $banner->id)
        );
    }
}
