<?php

namespace interactivesolutions\honeycombbanners\app\http\controllers;

use Illuminate\Database\Eloquent\Builder;
use interactivesolutions\honeycombcore\http\controllers\HCBaseController;
use interactivesolutions\honeycombbanners\app\models\HCBanners;
use interactivesolutions\honeycombbanners\app\validators\HCBannersValidator;
use interactivesolutions\honeycomburlshortener\app\models\HCShortURL;

class HCBannersController extends HCBaseController
{

    //TODO recordsPerPage setting

    /**
     * Returning configured admin view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex()
    {
        $config = [
            'title'       => trans('HCBanners::banners.page_title'),
            'listURL'     => route('admin.api.routes.banners'),
            'newFormUrl'  => route('admin.api.form-manager', ['banners-new']),
            'editFormUrl' => route('admin.api.form-manager', ['banners-edit']),
            'imagesUrl'   => route('resource.get', ['/']),
            'headers'     => $this->getAdminListHeader(),
        ];

        if( auth()->user()->can('interactivesolutions_honeycomb_banners_routes_banners_create') )
            $config['actions'][] = 'new';

        if( auth()->user()->can('interactivesolutions_honeycomb_banners_routes_banners_update') ) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }

        if( auth()->user()->can('interactivesolutions_honeycomb_banners_routes_banners_delete') )
            $config['actions'][] = 'delete';

        $config['actions'][] = 'search';
        $config['filters'] = $this->getFilters();

        return hcview('HCCoreUI::admin.content.list', ['config' => $config]);
    }

    /**
     * Creating Admin List Header based on Main Table
     *
     * @return array
     */
    public function getAdminListHeader()
    {
        return [
            'resource_id'      => [
                "type"  => "image",
                "label" => trans('HCBanners::banners.resource_id'),
            ],
            'banner_type.name' => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.banner_type_id'),
            ],
            'name'             => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.name'),
            ],
            'banner_url'       => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.banner_url'),
            ],
            'start_at'         => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.start_at'),
            ],
            'end_at'           => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.end_at'),
            ],
            'short_url.clicks' => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.clicks'),
            ],
            'shows'            => [
                "type"  => "text",
                "label" => trans('HCBanners::banners.shows'),
            ],
        ];
    }

    /**
     * Create item
     *
     * @return mixed
     */
    protected function __apiStore()
    {
        $data = $this->getInputData();

        $data = $this->getShortUrlId($data);

        $record = HCBanners::create(array_get($data, 'record'));
        $record->handleBanner(array_get($data, 'record.resource_id'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing item based on ID
     *
     * @param $id
     * @return mixed
     */
    protected function __apiUpdate(string $id)
    {
        $record = HCBanners::findOrFail($id);

        $data = $this->getInputData();

        $data = $this->getShortUrlId($data);

        $record->update(array_get($data, 'record', []));
        $record->handleBanner(array_get($data, 'record.resource_id'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing specific items based on ID
     *
     * @param string $id
     * @return mixed
     */
    protected function __apiUpdateStrict(string $id)
    {
        HCBanners::where('id', $id)->update(request()->all());

        return $this->apiShow($id);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiDestroy(array $list)
    {
        HCBanners::destroy($list);

        return hcSuccess();
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiForceDelete(array $list)
    {
        HCBanners::onlyTrashed()->whereIn('id', $list)->forceDelete();

        return hcSuccess();
    }

    /**
     * Restore multiple records
     *
     * @param $list
     * @return mixed
     */
    protected function __apiRestore(array $list)
    {
        HCBanners::whereIn('id', $list)->restore();

        return hcSuccess();
    }

    /**
     * Creating data query
     *
     * @param array $select
     * @return mixed
     */
    protected function createQuery(array $select = null)
    {
        $with = ['short_url', 'banner_type'];

        if( $select == null )
            $select = HCBanners::getFillableFields();

        $list = HCBanners::with($with)->select($select)
            // add filters
            ->where(function ($query) use ($select) {
                $query = $this->getRequestParameters($query, $select);
            });

        // enabling check for deleted
        $list = $this->checkForDeleted($list);

        // add search items
        $list = $this->search($list);

        // ordering data
        $list = $this->orderData($list, $select);

        return $list;
    }

    /**
     * List search elements
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     */
    protected function searchQuery(Builder $query, string $phrase)
    {
        return $query->where(function (Builder $query) use ($phrase) {
            $query->where('banner_type_id', 'LIKE', '%' . $phrase . '%')
                ->orWhere('resource_id', 'LIKE', '%' . $phrase . '%')
                ->orWhere('name', 'LIKE', '%' . $phrase . '%')
                ->orWhere('banner_url', 'LIKE', '%' . $phrase . '%')
                ->orWhere('start_at', 'LIKE', '%' . $phrase . '%')
                ->orWhere('end_at', 'LIKE', '%' . $phrase . '%');
        });
    }

    /**
     * Getting user data on POST call
     *
     * @return mixed
     */
    protected function getInputData()
    {
        (new HCBannersValidator())->validateForm();

        $_data = request()->all();

        if( array_has($_data, 'id') )
            array_set($data, 'record.id', array_get($_data, 'id'));

        array_set($data, 'record.banner_type_id', array_get($_data, 'banner_type_id'));
        array_set($data, 'record.resource_id', array_get($_data, 'resource_id'));
        array_set($data, 'record.name', array_get($_data, 'name'));
        array_set($data, 'record.banner_url', array_get($_data, 'banner_url'));
        array_set($data, 'record.start_at', array_get($_data, 'start_at'));
        array_set($data, 'record.end_at', array_get($_data, 'end_at'));
        array_set($data, 'record.link_type', array_get($_data, 'link_type'));
        array_set($data, 'record.link_title', array_get($_data, 'link_title'));
        array_set($data, 'record.short_url_id', array_get($_data, 'short_url_id'));
        array_set($data, 'record.sequence', array_get($_data, 'sequence'));
        array_set($data, 'record.shows', array_get($_data, 'shows', 0));

        if( array_get($data, 'record.end_at') == "" ) {
            array_set($data, 'record.end_at', null);
        }

        return $data;
    }

    /**
     * Getting single record
     *
     * @param $id
     * @return mixed
     */
    public function apiShow(string $id)
    {
        $with = ['short_url' => function ($query) {
            $query->select('id', 'url', 'short_url_key', 'clicks');
        }];

        $select = HCBanners::getFillableFields();

        $record = HCBanners::with($with)
            ->select($select)
            ->where('id', $id)
            ->firstOrFail();

        $record->link_hash = $record->short_url->short_url_key;

        return $record;
    }

    /**
     * Generating filters required for admin view
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = [];

        return $filters;
    }

    /**
     * Get link id
     *
     * @param $data
     * @return mixed
     */
    private function getShortUrlId($data)
    {
        $url = array_get($data, 'record.banner_url');

        $shortUrl = HCShortURL::where('url', $url)->orWhere('short_url_key', request('hash'))->first();

        if( ! $shortUrl ) {
            $shortUrl = generateHCShortURL($url, array_get($data, 'record.name'), true);
        }

        array_set($data, 'record.short_url_id', $shortUrl->id);

        return $data;
    }
}
