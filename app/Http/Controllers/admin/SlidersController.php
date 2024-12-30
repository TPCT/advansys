<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Slider\Slider;
use Awcodes\Curator\Models\Media;
use Dotenv\Validator;

class SlidersController extends Controller
{
    private function delete($category, $id){
        $slider = Slider::whereCategory($category)->with('slides')->first();
        $slide = $slider->slides()->findOrFail($id);
        $slide->delete();
        return Responses::success([], 200, __("site.Slide Deleted Successfully"));
    }

    private function show($category){
        $slider = Slider::whereCategory($category)->with('slides')->first();
        return Responses::success($slider);
    }

    private function create($category, $data){
        $slider = Slider::whereCategory($category)->with('slides')->first();
        $slider->slides()->create($data);
        return Responses::success($slider);
    }

    private function update($category, $id, $data){
        $slider = Slider::whereCategory($category)->with('slides')->first();
        $slide = $slider->slides()->findOrFail($id);
        $slide->update($data);
        return Responses::success($slide);
    }

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
        return $data;
    }

    public function hero($locale, $id=null){

        if (request()->method() == 'GET')
           return $this->show(Slider::HOMEPAGE_HERO_SLIDER);

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

            $data = $this->image($data);
            $data = $this->localized_data($data);

            if (!$id)
                return $this->create(Slider::HOMEPAGE_HERO_SLIDER, $data);
            else
                return $this->update(Slider::HOMEPAGE_HERO_SLIDER, $id, $data);

        }

        if (request()->method() == 'DELETE')
            return $this->delete(Slider::HOMEPAGE_HERO_SLIDER, $id);

        return Responses::error([], 501, __("errors.Unsupported Method"));
    }
    public function projects($locale, $id=null){
        if (request()->method() == 'GET')
            return $this->show(Slider::HOMEPAGE_PROJECTS_SLIDER);

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

            $data = $this->image($data);
            $data = $this->localized_data($data);

            if (!$id)
                return $this->create(Slider::HOMEPAGE_PROJECTS_SLIDER, $data);
            else
                return $this->update(Slider::HOMEPAGE_PROJECTS_SLIDER, $id, $data);
        }

        if (request()->method() == 'DELETE')
            return $this->delete(Slider::HOMEPAGE_PROJECTS_SLIDER, $id);

        return Responses::error([], 501, __("errors.Unsupported Method"));
    }

    public function feedbacks($locale, $id=null){
        if (request()->method() == 'GET')
            return $this->show(Slider::HOMEPAGE_FEEDBACK_SLIDER);

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

            $data = $this->localized_data($data);

            if (!$id)
                return $this->create(Slider::HOMEPAGE_FEEDBACK_SLIDER, $data);
            else
                return $this->update(Slider::HOMEPAGE_FEEDBACK_SLIDER, $id, $data);
        }

        if (request()->method() == 'DELETE')
            return $this->delete(Slider::HOMEPAGE_FEEDBACK_SLIDER, $id);

        return Responses::error([], 501, __("errors.Unsupported Method"));
    }

    public function partners($locale, $id=null){
        if (request()->method() == 'GET')
            return $this->show(Slider::HOMEPAGE_PARTNERS_SLIDER);

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

            $data = $this->image($data);
            $data = $this->localized_data($data);

            if (!$id)
                return $this->create(Slider::HOMEPAGE_PARTNERS_SLIDER, $data);
            else
                return $this->update(Slider::HOMEPAGE_PARTNERS_SLIDER, $id, $data);
        }

        if (request()->method() == 'DELETE')
            return $this->delete(Slider::HOMEPAGE_PARTNERS_SLIDER, $id);

        return Responses::error([], 501, __("errors.Unsupported Method"));
    }
}
