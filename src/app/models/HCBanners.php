<?php

namespace interactivesolutions\honeycombbanners\app\models;

use Carbon\Carbon;
use interactivesolutions\honeycombbanners\app\models\banners\HCBannerTypes;
use interactivesolutions\honeycombcore\models\HCUuidModel;
use interactivesolutions\honeycombresources\app\models\HCResources;
use interactivesolutions\honeycombresources\app\models\resources\HCThumbs;
use interactivesolutions\honeycomburlshortener\app\models\HCShortURL;

class HCBanners extends HCUuidModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'banner_type_id', 'resource_id', 'name', 'banner_url', 'start_at', 'end_at', 'short_url_id', 'link_type', 'link_title', 'type', 'shows', 'sequence'];

    /**
     * Relation to type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banner_type()
    {
        return $this->belongsTo(HCBannerTypes::class, 'banner_type_id', 'id');
    }

    /**
     * Relation to resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resource()
    {
        return $this->belongsTo(HCResources::class, 'resource_id', 'id');
    }

    /**
     * Relation to short url
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function short_url()
    {
        return $this->belongsTo(HCShortURL::class, 'short_url_id', 'id');
    }

    /**
     * Active banner time
     *
     * @param $query
     * @return mixed
     */
    public function scopeIsActiveTime($query)
    {
        $currentDate = Carbon::now()->toDateTimeString();

        return $query->where(function ($query) use ($currentDate) {
            $query->where('start_at', '<=', $currentDate)
                ->where(function ($query) use ($currentDate) {
                    $query->where('end_at', '>', $currentDate)
                        ->orWhereNull('end_at');
                });
        });
    }

    /**
     * Update banner info by resource type
     *
     * @param $resourceId
     * @throws \Exception
     */
    public function handleBanner($resourceId)
    {
        if( is_null($this->type) && $resourceId ) {

            $resource = HCResources::findOrFail($resourceId);

            if( $resource->extension == '.zip' ) {
                $this->storeZipBanner($resource);

                // save data
                $this->type = 'zip';
                $this->save();

            } elseif( $resource->extension == '.png' || $resource->extension == '.jpeg' || $resource->extension == '.jpg' ) {

                \Artisan::call('hc:generate-thumb', ['id' => $resourceId, 'rule' => $this->banner_type_id]);

                // save data
                $this->type = 'image';
                $this->save();
            } else {
                throw new \Exception(trans('ocv3banners::banners.errors.invalid_resource'));
            }
        }
    }

    /**
     * @param $resource
     * @return string
     */
    protected function storeZipBanner($resource)
    {
        $zip = new \ZipArchive();

        if( $zip->open($resource->file_path()) !== 11 && $this->hasIndexHtmlFile($zip)) {
            // extract to public
            $zip->extractTo(storage_path('app/public/banners' . DIRECTORY_SEPARATOR . $this->id));
        }
    }

    /**
     * @param $zip
     * @return string
     * @throws \Exception
     */
    private function hasIndexHtmlFile($zip)
    {
        $found = false;

        for ( $i = 0; $i < $zip->numFiles; $i++ ) {
            $filename = $zip->getNameIndex($i);

            if( $filename == 'index.html' ) {
                // all good
                $found = true;
                break;
            }
        }

        if( ! $found ) {
            throw new \Exception(trans('HCBanners::banners.errors.no_html_file'));
        }

        return $found;
    }
}