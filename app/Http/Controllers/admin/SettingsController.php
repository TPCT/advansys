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
            'site.logo' => app(Site::class)->translate('logo'),
            'site.footer_logo' => app(Site::class)->translate('footer_logo'),
            'site.footer_description' => app(Site::class)->footer_description,
            'site.fav_icon' => Media::find(app(Site::class)->fav_icon)->url,
            'site.email' => app(Site::class)->email,
            'site.phone' => app(Site::class)->phone,
            'site.address' => app(Site::class)->address,
            'general.title' => app(General::class)->site_title,
            'general.description' => app(General::class)->site_description,
            'general.admin_email' => app(General::class)->site_admin_email,
            'general.default_locale' => app(General::class)->default_locale,
            'general.country' => app(General::class)->site_country,
            'general.timezone' => app(General::class)->site_timezone
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
            'site.logo',
            'site.footer_logo',
            'site.footer_description',
            'site.fav_icon',
            'site.email',
            'site.phone',
            'site.address',
            'general.site_title',
            'general.site_description',
            'general.site_admin_email',
            'general.country',
            'general.timezone',
            'general.default_locale',
        ]);

        $validator = \Validator::make($data, [
            'site.logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site.footer_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site.footer_description' => 'sometimes|array',
            'site.footer_description.*' => 'string|nullable',
            'site.fav_icon' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site.email' => 'sometimes|email',
            'site.phone' => 'sometimes|string',
            'site.address' => 'sometimes|array',
            'site.address.*' => 'string|nullable',
            'general.site_title' => 'sometimes|array',
            'general.site_title.*' => 'string|nullable',
            'general.site_description' => 'sometimes|array',
            'general.site_description.*' => 'string|nullable',
            'general.site_admin_email' => 'sometimes|email',
            'general.country' => 'sometimes',
            'general.timezone' => 'sometimes',
            'general.default_locale' => 'sometimes|exists:languages,locale'
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
                        if (request()->hasFile('site.' . $key)) {
                            $file = request()->file('site.' . $key);
                            $filename = \Str::uuid() . '.' . $file->extension();
                            request()->file('site.' . $key)->storePubliclyAs('public/media', $filename);
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
                    if (request()->hasFile('site.fav_icon')){
                        $filename = \Str::uuid() . '.' . $value->extension();
                        request()->file('site.fav_icon')->storePubliclyAs('public/media', $filename);
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

        if (request()->has('general')){
            $settings = app(General::class);
            foreach(request()->general as $key => $value){
                $settings->$key = $value;
            }
            $settings->save();
        }

        return Responses::success([], 200, __("site.Settings updated successfully"));
    }
}
