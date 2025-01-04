<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\News\News;
use App\Models\Newsletter;
use App\Models\OurValue\OurValue;
use App\Models\Service\Service;
use App\Models\Slider\Slider;
use App\Models\TeamMember\TeamMember;
use App\Settings\Site;
use Awcodes\Curator\Models\Media;

class FrontendController extends Controller
{
    public function home(){
        $services = Service::all();
        $services->load('sub_services');

        $team_members = TeamMember::all();
        $blogs = News::latest()->take(3)->get();

        return Responses::success([
            'hero-slider' => Slider::whereCategory(Slider::HOMEPAGE_HERO_SLIDER)->first()->slides,
            'who_we_are' => [
                'number_of_projects' => app(Site::class)->number_of_projects,
                'number_of_years' => app(Site::class)->number_of_years,
                'title' => app(Site::class)->translate('who_we_are_title'),
                'description' => app(Site::class)->translate('who_we_are_description'),
            ],
            'services' => $services,
            'tabs' => [
                'tab_1' => [
                    'title' => app(Site::class)->translate('tab_1_title'),
                    'description' => app(Site::class)->translate('tab_1_description'),
                ],
                'tab_2' => [
                    'title' => app(Site::class)->translate('tab_2_title'),
                    'description' => app(Site::class)->translate('tab_2_description'),
                ]
            ],
            'projects' => Slider::whereCategory(Slider::HOMEPAGE_PROJECTS_SLIDER)->first()->slides,
            'feedbacks' => Slider::whereCategory(Slider::HOMEPAGE_FEEDBACK_SLIDER)->first()->slides,
            'partners' => Slider::whereCategory(Slider::HOMEPAGE_PARTNERS_SLIDER)->first()->slides,
            'team-members' => $team_members,
            'blogs' => $blogs,
        ]);
    }

    public function blog($locale, News $blog){
        $recent_blogs = News::where('id', '!=', $blog->id)->take(3)->get();
        return Responses::success([
            'blog' => $blog,
            'author' => $blog->author,
            'recent_blogs' => $recent_blogs,
        ]);
    }

    public function service($locale, Service $service){
        $service->load('sub_services');
        return Responses::success($service);
    }

    public function contact_us(){
        if (request()->method() == "GET"){
            return Responses::success([
               'cover_image' => Media::find(app(Site::class)->contact_us_cover_image)?->url,
               'address' => app(Site::class)->translate('address'),
               'phone' => app(Site::class)->translate('phone'),
               'email' => app(Site::class)->translate('email'),
            ]);
        }

        $validations = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'website' => 'required|url',
            'message' => 'required|string',
        ];

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        ContactUs::create($data);
        return Responses::success([], 200, __("site.Contact Us Submit Successfully"));
    }

    public function newsletter(){
        $validations = [
            'email' => 'required|email',
        ];

        $data = request()->only(array_keys($validations));
        $validator = \Validator::make($data, $validations);

        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));

        $data['blog_id'] = request()->blog_id;
        Newsletter::create($data);
        return Responses::success([], 200, __("site.NewsLetter Submit Successfully"));
    }

    public function about_us(){
        $our_values = OurValue::all();

        return Responses::success([
            'cover_image' => Media::find(app(Site::class)->about_us_cover_image)?->url,
            'image' => Media::find(app(Site::class)->about_us_image)?->url,
            'title' => app(Site::class)->translate('about_us_title'),
            'description' => app(Site::class)->translate('about_us_description'),
            'mission_description' => app(Site::class)->translate('mission_description'),
            'vision_description' => app(Site::class)->translate('vision_description'),
            'our_values' => $our_values,
        ]);
    }

    public function settings(){
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
            'footer_description' => app(Site::class)->translate('footer_description'),
            'address' => app(Site::class)->translate('address'),
            'who_we_are_title' => app(Site::class)->translate('who_we_are_title'),
            'who_we_are_description' => app(Site::class)->translate('who_we_are_description'),
            'tab_1_title' => app(Site::class)->translate('tab_1_title'),
            'tab_1_description' => app(Site::class)->translate('tab_1_description'),
            'tab_2_title' => app(Site::class)->translate('tab_2_title'),
            'tab_2_description' => app(Site::class)->translate('tab_2_description'),
            'about_us_title' => app(Site::class)->translate('about_us_title'),
            'about_us_description' => app(Site::class)->translate('about_us_description'),
            'vision_description' => app(Site::class)->translate('vision_description'),
            'mission_description' => app(Site::class)->translate('mission_description'),
        ];

        $settings['gallery'] = Media::latest()->take(6)->get()->transform(function($item){
            return ['image' => $item->url];
        });

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
}
