<?php

namespace interactivesolutions\honeycombbanners\app\models\banners;

use interactivesolutions\honeycombbanners\app\models\HCBanners;
use interactivesolutions\honeycombcore\models\HCUuidModel;

class HCBannerTypes extends HCUuidModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_banners_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'width', 'height'];

    /**
     * Relation to banners
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banners()
    {
        return $this->hasMany(HCBanners::class, 'banner_type_id', 'id');
    }
}