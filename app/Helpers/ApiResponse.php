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
        foreach($output as $key => $value){
            if (in_array($key, $translated_attributes) || in_array($key . "_id", $translated_attributes)) {
                unset($output[$key]);
            }
        }

        if ($this->translations) {
            unset($attributes['translations']);
            $output['translations'] = [];
            foreach ($this->translations as $translation) {
                $translation_output = [];
                $this->filter_translated_attributes($translation->toArray(), $image_uploads, $translated_attributes, $translation_output, true);
                $output['translations'][] = $translation_output;
            }
        }
        return $output;
    }
}