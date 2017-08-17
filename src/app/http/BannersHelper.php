<?php

namespace interactivesolutions\honeycombbanners\app\http;

use interactivesolutions\honeycombbanners\app\models\banners\HCBannerTypes;
use interactivesolutions\honeycombbanners\app\models\HCBanners;

class BannersHelper
{
    /**
     * Shuffle banners
     *
     * @var
     */
    protected $shuffled;

    /**
     * Order by position banners
     *
     * @var
     */
    protected $sequenced;

    /**
     * Get banner information by position
     *
     * @return array
     */
    public function getBannersByTypes()
    {
        $bannerTypes = HCBannerTypes::select('id', 'name', 'width', 'height')
            ->with(['banners' => function ($query) {
                $query->with(['short_url', 'banner_type' => function ($query) {
                    $query->select('id', 'name', 'width', 'height');
                }]);

                if( $this->shuffled ) {
                    $query->inRandomOrder();
                } else if( $this->sequenced ) {
                    $query->orderBy('sequence');
                }
            }])
            ->has('banners')
            ->isActive()
            ->get()
            ->map(function ($item, $key) {
                return $this->_formatBannerType($item);
            })->toArray();

        return $bannerTypes;
    }

    /**
     * Get banners by given banner type id
     *
     * @param $typeId
     * @return array
     */
    public function getBannersByTypeId($typeId)
    {
        $banners = HCBanners::whereHas('banner_type', function ($query) use ($typeId) {
            $query->where('id', $typeId)
                ->isActive();
        })->isActiveTime();

        if( $this->shuffled ) {
            $banners->inRandomOrder();
        }

        if( $this->sequenced ) {
            $banners->orderBy('sequence');
        }

        $banners = $banners->get();

        return $this->_formatBanners($banners);
    }

    /**
     * Get banners by given id
     *
     * @param $id
     * @return array
     */
    public function getBanner($id)
    {
        $banner = HCBanners::has('banner_type')->isActiveTime()->find($id);

        return $this->_formatBanner($banner);
    }

    /**
     * Randomize banners, use before getBanners function
     *
     * @return mixed
     */
    public function shuffled()
    {
        $this->shuffled = true;

        return $this;
    }

    /**
     * Order by position
     *
     * @return mixed
     */
    public function sequenced()
    {
        $this->sequenced = true;

        return $this;
    }

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

    /**
     * Format banner type
     *
     * @param $item
     * @return mixed
     */
    protected function _formatBannerType($item)
    {
        $banners = $this->_formatBanners($item->banners);

        array_forget($item, 'banners');

        $item['banners'] = $banners;

        return $item;
    }

    /**
     * Format banners
     *
     * @param $banners
     * @return array
     */
    protected function _formatBanners($banners)
    {
        return $banners->map(function ($banner, $key) {
            return $this->_formatBanner($banner);
        });
    }

    /**
     * Format final banner data
     *
     * @param $banner
     * @return array
     */
    protected function _formatBanner($banner)
    {
        if( ! $banner ) {
            return [];
        }

        return [
            'name'           => $banner->name,
            'banner_id'      => $banner->id,
            'banner_type_id' => $banner->banner_type_id,
            'type'           => $banner->type,
            'link_url'       => $banner->short_url ? $banner->short_url->short_url_link : null,
            'target'         => $banner->link_type,
            'link_name'      => $banner->link_name,
            'html'           => $this->iFrameTpl(route('ads.banner.show', $banner->id), $banner->banner_type->width, $banner->banner_type->height),
            'start_at'       => $banner->start_at,
            'end_at'         => $banner->end_at,
            'sequence'       => $banner->sequence,
        ];
    }

    /**
     * @param $item
     * @return string
     */
    public function getBannerHtml($item)
    {
        $html = '';

        if( $item->type == 'image' ) {
            $html = $this->imageTpl(
                route('resource.get', $item->resource_id), $item->banner_type->width, $item->banner_type->height
            );
        } else if( $item->type == 'zip' ) {
            $html = $this->iFrameTpl(
                $this->getIFrameLink($item), $item->banner_type->width, $item->banner_type->height
            );
        }

        return $html;
    }
}
