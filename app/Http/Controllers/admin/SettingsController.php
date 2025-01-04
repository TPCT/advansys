<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Settings\General;
use App\Settings\Site;
use Awcodes\Curator\Models\Media;

class SettingsController extends Controller
{
    public function index(){
        $settings = [
            'logo' => Media::find(app(Site::class)->translate('logo'))?->url,
            'footer_logo' => Media::find(app(Site::class)->translate('footer_logo'))?->url,
            'fav_icon' => Media::find(app(Site::class)->fav_icon)?->url,
            'contact_us_cover_image' => Media::find(app(Site::class)->contact_us_cover_image)?->url,
            'about_us_cover_image' => Media::find(app(Site::class)->about_us_cover_image)?->url,
            'about_us_image' => Media::find(app(Site::class)->about_us_image)?->url,
            'email' => app(Site::class)->email,
            'phone' => app(Site::class)->phone,
            'number_of_projects' => app(Site::class)->number_of_projects,
            'number_of_years' => app(Site::class)->number_of_years,
        ];

        $translatable = [
            'footer_description' => app(Site::class)->footer_description,
            'address' => app(Site::class)->address,
            'who_we_are_title' => app(Site::class)->who_we_are_title,
            'who_we_are_description' => app(Site::class)->who_we_are_description,
            'tab_1_title' => app(Site::class)->tab_1_title,
            'tab_1_description' => app(Site::class)->tab_1_description,
            'tab_2_title' => app(Site::class)->tab_2_title,
            'tab_2_description' => app(Site::class)->tab_2_description,
            'about_us_title' => app(Site::class)->about_us_title,
            'about_us_description' => app(Site::class)->about_us_description,
            'vision_description' => app(Site::class)->vision_description,
            'mission_description' => app(Site::class)->mission_description,
        ];

        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $locale => $data) {
                    $settings[$key . "_" . $locale] = $data;
                }
                unset($settings[$key]);
            }
        }

        foreach($translatable as $key => $value){
            if (is_null($value)){
                foreach(config('app.locales') as $locale => $language)
                    $settings[$key . "_" . $locale] = $value;
            }elseif (is_array($value)){
                foreach ($value as $locale => $data) {
                    $settings[$key . "_" . $locale] = $data;
                }
            }
        }
        return Responses::success($settings);
    }

    public function update(){
        $keys =  [
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fav_icon' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact_us_cover_image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_us_cover_image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_us_image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'footer_description' => 'sometimes|array',
            'address' => 'sometimes|array',
            'number_of_projects' => 'sometimes|integer',
            'number_of_years' => 'sometimes|integer',
            'who_we_are_title' => 'sometimes|array',
            'who_we_are_description' => 'sometimes|array',
            'tab_1_title' => 'sometimes|array',
            'tab_1_description' => 'sometimes|array',
            'tab_2_title' => 'sometimes|array',
            'about_us_title' => 'sometimes|array',
            'about_us_description' => 'sometimes|array',
            'vision_description' => 'sometimes|array',
            'mission_description' => 'sometimes|array',
        ];

        $data = request()->only(array_keys($keys));


        $validator = \Validator::make($data, $keys);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $settings = app(Site::class);
        foreach($data as $key => $value){
            if (in_array($key, ['logo', 'footer_logo'])){
                $images = [];
                foreach (config('app.locales') as $locale => $language){
                    $images[$locale] = null;
                    if (request()->hasFile('' . $key)) {
                        $file = request()->file('' . $key);
                        $filename = \Str::uuid() . '.' . $file->extension();
                        request()->file('' . $key)->storePubliclyAs('public/media', $filename);
                        $images[$locale] = Media::create([
                            'disk' => 'public',
                            'directory' => 'media',
                            'visibility' => 'public',
                            'name' => $filename,
                            'path' => 'media/' . $filename,
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType(),
                            'ext' => $file->getClientOriginalExtension(),
                            'title' => $file->getClientOriginalName(),
                        ])->id;
                    }
                }
                $settings->$key = $images;
            }
            elseif (in_array($key, ['fav_icon', 'contact_us_cover_image', 'about_us_cover_image', 'about_us_image'])){
                $image = null;
                if (request()->hasFile($key)){
                    $filename = \Str::uuid() . '.' . $value->extension();
                    request()->file($key)->storePubliclyAs('public/media', $filename);
                    $image = Media::create([
                        'disk' => 'public',
                        'directory' => 'media',
                        'visibility' => 'public',
                        'name' => $filename,
                        'path' => 'media/' . $filename,
                        'size' => $value->getSize(),
                        'type' => $value->getMimeType(),
                        'ext' => $value->getClientOriginalExtension(),
                        'title' => $value->getClientOriginalName(),
                    ])->id;
                }

                $settings->$key = $image;
            }
            else{
                $settings->$key = $value;
            }
            $settings->save();
        }

        return Responses::success([], 200, __("Settings updated successfully"));
    }
}
