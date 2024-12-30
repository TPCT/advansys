<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\TeamMember\TeamMember;
use Awcodes\Curator\Models\Media;

class TeamMembersController extends Controller
{
    public function index(){
        return Responses::success(TeamMember::all());
    }

    public function show($locale, TeamMember $team_member){
        return Responses::success($team_member);
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

    public function create($locale, TeamMember $team_member){
        $validations = [
            'title' => 'required|array',
            'description' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'required|string|max:255';
            $validations['description.' . $locale] = 'required|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


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
        $data = $this->localized_data($data);
        $team_member->create($data);

        return Responses::success($team_member);
    }

    public function update($locale, TeamMember $team_member){
        $validations = [
            'title' => 'sometimes|array',
            'description' => 'sometimes|array',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        foreach (config('app.locales') as $locale => $language) {
            $validations['title.' . $locale] = 'sometimes|string|max:255';
            $validations['description.' . $locale] = 'sometimes|string|max:255';
        }

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));


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
        $team_member->update($data);

        return Responses::success($team_member);
    }

    public function delete($locale, TeamMember $team_member){
        $team_member->delete();
        return Responses::success([], 200, "site.Team member deleted successfully");
    }
}
