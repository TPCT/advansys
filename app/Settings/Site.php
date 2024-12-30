<?php

namespace App\Settings;

use App\Helpers\TranslatableSettings;
use Spatie\LaravelSettings\Settings;

class Site extends Settings
{

    private array $translatable = [
        'fav_icon', 'logo', 'footer_logo', 'address', 'footer_description'
    ];

    private array $uploads = [
        'fav_icon', 'logo', 'footer_logo'
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
    public ?array $footer_logo;
    public ?array $address;
    public ?array $footer_description;

    public static function group(): string
    {
        return 'site';
    }
}
