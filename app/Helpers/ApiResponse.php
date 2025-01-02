<?php

namespace App\Helpers;

use Awcodes\Curator\Models\Media;

trait ApiResponse
{
    public function get_api_hidden_attributes(){
        return ['created_at', 'deleted_at', 'updated_at', 'status', 'weight', 'order', 'pivot'];
    }

    private function filter_translated_attributes($attributes, $image_uploads, $translated_attributes, &$output, $remove_id=false){
        foreach ($attributes as $key => $value) {
            if ($key == "id" && $remove_id)
                continue;
            if (in_array($key, $image_uploads)) {
                $output[explode('_', $key)[0]] = Media::find($value)?->url ?: null;
            }
            elseif (!in_array($key, $translated_attributes)) {
                if (str_ends_with($key, '_id'))
                    continue;
                $output[$key] = $value;
            }
        }

        foreach ($translated_attributes as $key) {
            $output[$key] = $this->translate(app()->getLocale())->$key;
            if (in_array($key, $image_uploads)){
                $output[explode('_', $key)[0]] = Media::find($output[$key])?->url;
                unset($output[$key]);
            }
        }
        return $output;
    }
    public function toArray(){
        $this->refresh();
        $api_hidden_attributes = $this->get_api_hidden_attributes();
        $this->makeHidden($api_hidden_attributes);
        $attributes = Parent::toArray();
        if (request()->segment(2) !== 'api')
            return $attributes;

        $output = [];
        $translated_attributes = $this->translatedAttributes ?? [];
        $image_uploads = $this->upload_attributes ?? [];

        $this->filter_translated_attributes($attributes, $image_uploads, $translated_attributes, $output);
        if (request()->segment(3) === 'admin'){
            foreach($output as $key => $value){
                if (in_array($key, $translated_attributes) || in_array($key . "_id", $translated_attributes)) {
                    unset($output[$key]);
                }
            }

            if ($this->translations) {
                unset($attributes['translations']);
                foreach ($this->translations->toArray() as $translation) {
                    foreach ($translation as $key => $value) {
                        if (!in_array($key, $translated_attributes))
                            continue;
                        $output[$key. "_" . $translation['language']] = $value;
                    }
                }
            }
        }
        unset($output['translations']);
        return $output;
    }
}