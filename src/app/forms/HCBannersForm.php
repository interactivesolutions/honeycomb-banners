<?php

namespace interactivesolutions\honeycombbanners\app\forms;

use interactivesolutions\honeycombbanners\app\models\banners\HCBannerTypes;

class HCBannersForm
{
    // name of the form
    protected $formID = 'banners';

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
            'storageURL' => route('admin.api.routes.banners'),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCTranslations::core.buttons.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
                    "type"            => "dropDownList",
                    "fieldID"         => "banner_type_id",
                    "label"           => trans("HCBanners::banners.banner_type_id"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                    "options"         => HCBannerTypes::select('id', 'name')->get(),
                    "search"          => [
                        "maximumSelectionLength" => 1,
                        "minimumSelectionLength" => 0,
                    ],
                ],
                [
                    'type'            => 'resource',
                    'fieldID'         => 'resource_id',
                    'label'           => trans('HCBanners::banners.resource_id'),
                    "required"        => 1,
                    "requiredVisible" => 1,
                    "uploadURL"       => route("admin.api.resources"),
                    "viewURL"         => route("resource.get", "/"),
                    "uploadDataTypes" => ['image/jpeg', 'image/png', 'application/zip', 'application/x-zip-compressed'],
                    "uploadSize"      => "5120000",
                    "fileCount"       => 1,
                ],
                [
                    "type"            => "singleLine",
                    "fieldID"         => "name",
                    "label"           => trans("HCBanners::banners.name"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
                [
                    "type"            => "singleLine",
                    "fieldID"         => "banner_url",
                    "label"           => trans("HCBanners::banners.banner_url"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
                [
                    'type'            => 'radioList',
                    'fieldID'         => 'link_type',
                    'label'           => trans('HCBanners::banners.link_type'),
                    "required"        => 1,
                    "requiredVisible" => 1,
                    "options"         => [
                        [
                            'id'    => '_blank',
                            'label' => '_blank',
                        ],
                        [
                            'id'    => '_self',
                            'label' => '_self',
                        ],
                    ],
                ],
                [
                    "type"            => "dateTimePicker",
                    "fieldID"         => "start_at",
                    "label"           => trans("HCBanners::banners.start_at"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                    "properties"      => [
                        "format" => "YYYY-MM-DD HH:mm:ss",
                    ],
                ],
                [
                    "type"            => "dateTimePicker",
                    "fieldID"         => "end_at",
                    "label"           => trans("HCBanners::banners.end_at"),
                    "required"        => 0,
                    "requiredVisible" => 0,
                    "properties"      => [
                        "format" => "YYYY-MM-DD HH:mm:ss",
                    ],
                ],
            ],
        ];

        if( $this->multiLanguage )
            $form['availableLanguages'] = getHCContentLanguages();

        if( ! $edit )
            return $form;

        $hash = [
            'type'     => 'singleLine',
            'fieldID'  => 'link_hash',
            'label'    => trans("HCBanners::banners.hash"),
            'readonly' => 1,
        ];

        $type = [
            'type'     => 'singleLine',
            'fieldID'  => 'type',
            'label'    => trans("HCBanners::banners.type"),
            'readonly' => 1,
        ];

        $form['structure'][] = $hash;
        $form['structure'][] = $type;

        $form = $this->makeNotEditableFields($form, ['resource']);

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }

    /**
     * @param $form
     * @param $fields
     * @return mixed
     */
    public function makeNotEditableFields($form, $fields)
    {
        if( ! is_array($fields) ) {
            $fields = [$fields];
        }

        foreach ( $form['structure'] as $key => $formItem ) {
            if( in_array($formItem['fieldID'], $fields) ) {
                $form['structure'][$key]['editType'] = 1;
            }
        }

        return $form;
    }
}