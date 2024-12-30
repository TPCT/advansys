<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Service\Service;
use Awcodes\Curator\Models\Media;

class ServicesController extends Controller
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

    public function index()
    {
        return Responses::success(Service::with('sub_services')->get());
    }

    public function show($locale, Service $service){
        $service->load('sub_services');
        return Responses::success($service);
    }

    public function create($locale){
        $validations = [
            'title' => 'required|array',
            'second_title' => 'required|array',
            'description' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['second_title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $service = Service::create($data);
        $service->load('sub_services');
        return Responses::success($service);
    }

    public function update($locale, Service $service){
        $validations = [
            'title' => 'required|array',
            'second_title' => 'required|array',
            'description' => 'required|array',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['second_title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $service->update($data);
        $service->load('sub_services');

        return Responses::success($service);
    }

    public function delete($locale, Service $service){
        $service->delete();
        return Responses::success([], 200, __("site.Service deleted successfully"));
    }
}
