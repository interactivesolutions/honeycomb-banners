<?php

namespace interactivesolutions\honeycombbanners\app\forms\banners;

class HCBannerTypesForm
{
    // name of the form
    protected $formID = 'banners-types';

    // is form multi language
    protected $multiLanguage = 0;

    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     */
    public function createForm(bool $edit = false)
    {
        $form = [
            'storageURL' => route('admin.api.routes.banners.types'),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCTranslations::core.buttons.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
                    "type"            => "singleLine",
                    "fieldID"         => "name",
                    "label"           => trans("HCBanners::banners_types.name"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
                [
                    "type"            => "singleLine",
                    "fieldID"         => "width",
                    "label"           => trans("HCBanners::banners_types.width"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
                [
                    "type"            => "singleLine",
                    "fieldID"         => "height",
                    "label"           => trans("HCBanners::banners_types.height"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
            ],
        ];

        if( $this->multiLanguage )
            $form['availableLanguages'] = getHCContentLanguages();

        if( ! $edit )
            return $form;

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }
}