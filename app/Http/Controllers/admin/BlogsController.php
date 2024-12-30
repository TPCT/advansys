<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\TeamMember\TeamMember;
use Awcodes\Curator\Models\Media;
use Illuminate\Http\Request;

class BlogsController extends Controller
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
        foreach (config('app.locales') as $locale => $language){
            if (request()->hasFile('image')) {
                $image = $data['image'];
                $filename = \Str::uuid() . '.' . $image->extension();
                request()->file('image')->storePubliclyAs('public/media', $filename);
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = News::paginate(10)->withQueryString();
        return Responses::success([
            'current_page' => $blogs->currentPage(),
            'per_page' => $blogs->perPage(),
            'total' => $blogs->total(),
            'blogs' => $blogs->getCollection()
        ]);
    }


    public function create()
    {
        $validations = [
            'title' => 'required|array',
            'description' => 'required|array',
            'content' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
            $validations['content.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $blog = News::create($data);

        return Responses::success($blog);
    }

    public function show($locale, News $blog)
    {
        return Responses::success($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, News $blog)
    {
        $validations = [
            'title' => 'required|array',
            'description' => 'required|array',
            'content' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
            $validations['content.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


        $data = $this->image($data);
        $data = $this->localized_data($data);
        $blog->update($data);

        return Responses::success($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, News $blog)
    {
        $blog->delete();
        return Responses::success([], 200, __("site.Blog deleted successfully"));
    }
}
