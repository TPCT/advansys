<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.number_of_projects');
        $this->migrator->add('site.number_of_years');
        $this->migrator->add('site.who_we_are_title');
        $this->migrator->add('site.who_we_are_description');
        $this->migrator->add('site.tab_1_title');
        $this->migrator->add('site.tab_1_description');
        $this->migrator->add('site.tab_2_title');
        $this->migrator->add('site.tab_2_description');
        $this->migrator->add('site.contact_us_cover_image');
        $this->migrator->add('site.about_us_cover_image');
        $this->migrator->add('site.about_us_image');
        $this->migrator->add('site.about_us_title');
        $this->migrator->add('site.about_us_description');
        $this->migrator->add('site.vision_description');
        $this->migrator->add('site.mission_description');
    }
};
