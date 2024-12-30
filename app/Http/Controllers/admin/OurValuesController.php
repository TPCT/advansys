<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\OurValue\OurValue;
use App\Models\Service\Service;
use Awcodes\Curator\Models\Media;

class OurValuesController extends Controller
{
    private function localized_data($data){
        $localized_data = [];
        foreach (config('app.locales') as $locale => $language) {
            $localized_data[$locale] = [];
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $localized_data[$locale][$key] = $value[$locale];
                    continue;
                }
                $localized_data[$key] = $value;
            }
        }
        return $localized_data;
    }

    private function image($data){
        if (request()->hasFile('image')) {
            $image = $data['image'];
            $filename = \Str::uuid() . '.' . $image->extension();
            request()->file('image')->storePubliclyAs('public/media', $filename);
            $data['image_id'] = Media::create([
                'disk' => 'public',
                'directory' => 'media',
                'visibility' => 'public',
                'name' => $filename,
                'path' => 'media/' . $filename,
                'size' => $image->getSize(),
                'type' => $image->getMimeType(),
                'ext' => $image->getClientOriginalExtension(),
                'title' => $image->getClientOriginalName(),
            ])->id;
            unset($data['image']);
        }
        return $data;
    }

    public function index(){
        return Responses::success(OurValue::all());
    }

    public function create(){
        $validations = [
            'title' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $service = OurValue::create($data);
        return Responses::success($service);
    }

    public function delete($locale, OurValue $our_value){
        $our_value->delete();
        return Responses::success([], 200, __("site.Service deleted successfully"));
    }
}
