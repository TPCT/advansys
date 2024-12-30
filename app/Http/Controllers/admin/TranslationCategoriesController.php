<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Service\Service;
use App\Models\Translation\TranslationCategory;

class TranslationCategoriesController extends Controller
{
    public function index(){
        return Responses::success(TranslationCategory::all()->transform(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
            ];
        }));
    }

    public function create(){
        $validations = [
            'title' => 'required|string|max:255',
        ];

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $category = TranslationCategory::create($data);
        return Responses::success($category);
    }

    public function update($locale, TranslationCategory $category){
        $validations = [
            'title' => 'required|string|max:255',
        ];

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $category->update($data);
        return Responses::success($category);
    }

    public function delete($locale, TranslationCategory $category){
        $category->delete();
        return Responses::success([], 200, __("site.Translation Category deleted successfully"));
    }
}
