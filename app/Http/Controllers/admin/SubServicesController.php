<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Service\Service;
use App\Models\Service\SubService;
use Awcodes\Curator\Models\Media;

class SubServicesController extends Controller
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

    public function create($locale, Service $service){
        $validations = [
            'title' => 'required|array',
            'second_title' => 'required|array',
            'description' => 'required|array',
            'key_features' => 'required|array',
            'use_cases' => 'required|array',
            'benefits' => 'required|array',
            'why_us' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['second_title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
            $validations['key_features.' . $locale] = 'required|string|max:255';
            $validations['use_cases.' . $locale] = 'required|string|max:255';
            $validations['benefits.' . $locale] = 'required|string|max:255';
            $validations['why_us.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $service->sub_services()->create($data);
        $service->load('sub_services');

        return Responses::success($service);
    }

    public function update($locale, Service $service, SubService $sub_service){
        $sub_service = $service->sub_services()->findOrFail($sub_service->id);
        $validations = [
            'title' => 'required|array',
            'second_title' => 'required|array',
            'description' => 'required|array',
            'key_features' => 'required|array',
            'use_cases' => 'required|array',
            'benefits' => 'required|array',
            'why_us' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['second_title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
            $validations['key_features.' . $locale] = 'required|string|max:255';
            $validations['use_cases.' . $locale] = 'required|string|max:255';
            $validations['benefits.' . $locale] = 'required|string|max:255';
            $validations['why_us.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $sub_service->update($data);
        $service->load('sub_services');

        return Responses::success($service);
    }

    public function delete($locale, Service $service, SubService $sub_service){
        $sub_service = $service->sub_services()->findOrFail($sub_service->id);
        $sub_service->delete();
        return Responses::success([], 200, "site.Sub Service deleted successfully");
    }
}
