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
        $logos = [];

        $settings = [
            'logo' => app(Site::class)->translate('logo'),
            'footer_logo' => app(Site::class)->translate('footer_logo'),
            'footer_description' => app(Site::class)->footer_description,
            'fav_icon' => Media::find(app(Site::class)->fav_icon)->url,
            'email' => app(Site::class)->email,
            'phone' => app(Site::class)->phone,
            'address' => app(Site::class)->address,
        ];

        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $locale => $data) {
                    $settings[$key . "_" . $locale] = $data;
                }
                unset($settings[$key]);
            }
        }
        return Responses::success($settings);
    }

    public function update(){
        $data = request()->only([
            'logo',
            'footer_logo',
            'footer_description',
            'fav_icon',
            'email',
            'phone',
            'address',
        ]);

        $validator = \Validator::make($data, [
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_description' => 'sometimes|array',
            'footer_description.*' => 'string|nullable',
            'fav_icon' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'address' => 'sometimes|array',
            'address.*' => 'string|nullable',
        ]);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        if (request()->has('site')){
            $settings = app(Site::class);
            foreach(request()->site as $key => $value){
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
                    $settings->save();
                }
                elseif ($key == "fav_icon"){
                    $image = null;
                    if (request()->hasFile('fav_icon')){
                        $filename = \Str::uuid() . '.' . $value->extension();
                        request()->file('fav_icon')->storePubliclyAs('public/media', $filename);
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

                    $settings->fav_icon = $image;
                    $settings->save();
                }
                else{
                    $settings->$key = $value;
                }
            }
        }

        return Responses::success([], 200, __("Settings updated successfully"));
    }
}
