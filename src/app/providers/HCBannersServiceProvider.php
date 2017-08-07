<?php

namespace interactivesolutions\honeycombbanners\app\providers;

use interactivesolutions\honeycombcore\providers\HCBaseServiceProvider;

class HCBannersServiceProvider extends HCBaseServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycombbanners\app\http\controllers';

    public $serviceProviderNameSpace = 'HCBanners';
}





