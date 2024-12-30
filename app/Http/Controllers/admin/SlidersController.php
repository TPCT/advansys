<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Slider\Slider;
use Awcodes\Curator\Models\Media;
use Dotenv\Validator;

class SlidersController extends Controller
{
    public function index(){
        $sliders = Slider::all();
        return Responses::success($sliders);
    }

    public function hero($locale, $id=null){
        $slider = Slider::whereCategory(Slider::HOMEPAGE_HERO_SLIDER)->with('slides')->first();

        if (request()->method() == 'GET')
            return Responses::success($slider);

        if (request()->method() == 'POST'){
            $validations = [
                'title' => 'required|array',
                'second_title' => 'required|array',
                'slide_url' => 'required|array',
                'image' => 'required|array',
            ];

            foreach (config('app.locales') as $locale => $language) {
                $validations['title.' . $locale] = 'required|string|max:255';
                $validations['second_title.' . $locale] = 'required|string|max:255';
                $validations['slide_url.' . $locale] = 'required|string|max:255';
                $validations['image.' . $locale] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            $data = request()->only(array_keys($validations));
            $validator = \Validator::make($data, $validations);

            if ($validator->fails())
                return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

            foreach ($data['image'] as $locale => $image){
                if (request()->hasFile('image.'.$locale)) {
                    $filename = \Str::uuid() . '.' . $image->extension();
                    request()->file('image.' . $locale)->storePubliclyAs('public/media', $filename);
                    $data['image_id'][$locale] = Media::create([
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
                }
            }
            unset($data['image']);
            $localized_data = [];
            foreach (config('app.locales') as $locale => $language) {
                $localized_data[$locale] = [];
                foreach ($data as $key => $value)
                    $localized_data[$locale][$key] = $value[$locale];
            }

            if (!$id){
                $slider->slides()->create($localized_data);
                return Responses::success($slider);
            }else{
                $slide = $slider->slides()->findOrFail($id);
                $slide->update($localized_data);
                return Responses::success($slide);
            }
        }

        if (request()->method() == 'DELETE'){
            $slide = $slider->slides()->findOrFail($id);
            $slide->delete();
            return Responses::success([], 200, __("site.Slide Deleted Successfully"));
        }

        return Responses::error([], 501, __("errors.Unsupported Method"));
    }
    public function projects($locale, $id=null){
        $slider = Slider::whereCategory(Slider::HOMEPAGE_PROJECTS_SLIDER)->with('slides')->first();

        if (request()->method() == 'GET')
            return Responses::success($slider);

        if (request()->method() == 'POST'){
            $validations = [
                'title' => 'required|array',
                'second_title' => 'required|array',
                'image' => 'required|array',
            ];

            foreach (config('app.locales') as $locale => $language) {
                $validations['title.' . $locale] = 'required|string|max:255';
                $validations['second_title.' . $locale] = 'required|string|max:255';
                $validations['image.' . $locale] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            $data = request()->only(array_keys($validations));
            $validator = \Validator::make($data, $validations);

            if ($validator->fails())
                return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

            foreach ($data['image'] as $locale => $image){
                if (request()->hasFile('image.'.$locale)) {
                    $filename = \Str::uuid() . '.' . $image->extension();
                    request()->file('image.' . $locale)->storePubliclyAs('public/media', $filename);
                    $data['image_id'][$locale] = Media::create([
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
                }
            }
            unset($data['image']);
            $localized_data = [];
            foreach (config('app.locales') as $locale => $language) {
                $localized_data[$locale] = [];
                foreach ($data as $key => $value)
                    $localized_data[$locale][$key] = $value[$locale];
            }

            if (!$id){
                $slider->slides()->create($localized_data);
                return Responses::success($slider);
            }else{
                $slide = $slider->slides()->findOrFail($id);
                $slide->update($localized_data);
                return Responses::success($slide);
            }
        }

        if (request()->method() == 'DELETE'){
            $slide = $slider->slides()->findOrFail($id);
            $slide->delete();
            return Responses::success([], 200, __("site.Slide Deleted Successfully"));
        }
    }

    public function feedbacks($locale, $id=null){
        $slider = Slider::whereCategory(Slider::HOMEPAGE_FEEDBACK_SLIDER)->with('slides')->first();

        if (request()->method() == 'GET')
            return Responses::success($slider);

        if (request()->method() == 'POST'){
            $validations = [
                'rate' => 'required|integer|between:1,5',
                'title' => 'required|array',
                'second_title' => 'required|array',
                'description' => 'required|array',
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

            $localized_data = [];
            foreach (config('app.locales') as $locale => $language) {
                $localized_data[$locale] = [];
                foreach ($data as $key => $value){
                    if (is_array($value)) {
                        $localized_data[$locale][$key] = $value[$locale];
                        continue;
                    }
                    $localized_data[$key] = $value;
                }

            }

            if (!$id){
                $slider->slides()->create($localized_data);
                return Responses::success($slider);
            }else{
                $slide = $slider->slides()->findOrFail($id);
                $slide->update($localized_data);
                return Responses::success($slide);
            }
        }

        if (request()->method() == 'DELETE'){
            $slide = $slider->slides()->findOrFail($id);
            $slide->delete();
            return Responses::success([], 200, __("site.Slide Deleted Successfully"));
        }
    }

    public function partners($locale, $id=null){
        $slider = Slider::whereCategory(Slider::HOMEPAGE_PARTNERS_SLIDER)->with('slides')->first();

        if (request()->method() == 'GET')
            return Responses::success($slider);

        if (request()->method() == 'POST'){
            $validations = [
                'image' => 'required|array',
            ];

            foreach (config('app.locales') as $locale => $language) {
                $validations['image.' . $locale] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            $data = request()->only(array_keys($validations));
            $validator = \Validator::make($data, $validations);

            if ($validator->fails())
                return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

            foreach ($data['image'] as $locale => $image){
                if (request()->hasFile('image.'.$locale)) {
                    $filename = \Str::uuid() . '.' . $image->extension();
                    request()->file('image.' . $locale)->storePubliclyAs('public/media', $filename);
                    $data['image_id'][$locale] = Media::create([
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
                }
            }
            unset($data['image']);
            $localized_data = [];
            foreach (config('app.locales') as $locale => $language) {
                $localized_data[$locale] = [];
                foreach ($data as $key => $value)
                    $localized_data[$locale][$key] = $value[$locale];
            }

            if (!$id){
                $slider->slides()->create($localized_data);
                return Responses::success($slider);
            }else{
                $slide = $slider->slides()->findOrFail($id);
                $slide->update($localized_data);
                return Responses::success($slide);
            }
        }

        if (request()->method() == 'DELETE'){
            $slide = $slider->slides()->findOrFail($id);
            $slide->delete();
            return Responses::success([], 200, __("site.Slide Deleted Successfully"));
        }
    }


//    public function categories(){
//        return Responses::success(Slider::getCategories());
//    }
//
//    public function create(){
//        $data = request()->only('category');
//        $slider = Slider::create($data);
//        return Responses::success($slider);
//    }
}
