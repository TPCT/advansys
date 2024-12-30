<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Translation\Translation;
use App\Models\Translation\TranslationCategory;

class TranslationsController extends Controller
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

    public function index($locale, TranslationCategory $category){
        $records =  $category->translations()->paginate(20);
        return Responses::success([
            'current_page' => $records->currentPage(),
            'per_page' => $records->perPage(),
            'total' => $records->total(),
            'translations' => $records->getCollection()
        ]);
    }

public function create($locale, TranslationCategory $category){
        $validations = [
            'key' => 'required|string|max:255',
            'content' => 'required|array',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['content.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $data = $this->localized_data($data);
        $translation = $category->translations()->create($data);
        return Responses::success($translation);
    }

    public function update($locale, TranslationCategory $category, Translation $translation){
        $translation = $category->translations()->findOrFail($translation->id);

        $validations = [
            'key' => 'required|string|max:255',
            'content' => 'required|array',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['content.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $translation->update($data);

        return Responses::success($translation);
    }

    public function delete($locale, TranslationCategory $category, Translation $translation){
        $translation = $category->translations()->findOrFail($translation->id);
        $translation->delete();
        return Responses::success([], 200, __("site.Keyword deleted successfully"));
    }
}
