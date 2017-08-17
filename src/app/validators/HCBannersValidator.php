<?php namespace interactivesolutions\honeycombbanners\app\validators;

use interactivesolutions\honeycombcore\http\controllers\HCCoreFormValidator;

class HCBannersValidator extends HCCoreFormValidator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'resource_id' => 'required',
            'name'        => 'required',
            'banner_url'  => 'required',
            'start_at'    => 'required',
            'sequence'    => 'integer',
        ];
    }
}