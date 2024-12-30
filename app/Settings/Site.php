<?php

namespace App\Settings;

use App\Helpers\TranslatableSettings;
use Spatie\LaravelSettings\Settings;

class Site extends Settings
{

    private array $translatable = [
        'fav_icon', 'logo', 'footer_logo', 'address', 'footer_description',
        'who_we_are_title', 'who_we_are_description',
        'tab_1_title', 'tab_1_description',
        'tab_2_title', 'tab_2_description',
        'about_us_title', 'about_us_description',
        'vision_description', 'mission_description',
    ];

    private array $uploads = [
        'fav_icon', 'logo', 'footer_logo', 'contact_us_cover_image',
        'about_us_cover_image', 'about_us_image'
    ];

    public function translatable()
    {
        return $this->translatable;
    }

    public function uploads(){
        return $this->uploads;
    }

    use TranslatableSettings;

    public ?string $fav_icon;
    public ?string $email;
    public ?string $phone;
    public ?array $logo;
    public ?array $who_we_are_title;
    public ?array $who_we_are_description;
    public ?array $tab_1_title;
    public ?array $tab_1_description;
    public ?array $tab_2_title;
    public ?array $tab_2_description;
    public ?array $about_us_title;
    public ?array $about_us_description;
    public ?array $vision_description;
    public ?array $mission_description;

    public ?string $number_of_projects;
    public ?string $number_of_years;
    public ?string $contact_us_cover_image;
    public ?string $about_us_cover_image;
    public ?string $about_us_image;

    public ?array $footer_logo;
    public ?array $address;
    public ?array $footer_description;

    public static function group(): string
    {
        return 'site';
    }
}
