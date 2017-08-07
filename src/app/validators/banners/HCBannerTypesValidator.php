<?php

namespace interactivesolutions\honeycombbanners\app\validators\banners;

use interactivesolutions\honeycombcore\http\controllers\HCCoreFormValidator;

class HCBannerTypesValidator extends HCCoreFormValidator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name'       => 'required',
            'width'      => 'required|integer',
            'height'     => 'required|integer',
        ];
    }
}