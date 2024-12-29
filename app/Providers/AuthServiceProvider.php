<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Activity\Activity;
use App\Models\Album\Album;
use App\Models\Audit;
use App\Models\Award\Award;
use App\Models\Block\Block;
use App\Models\BoothVoucher\BoothVoucher;
use App\Models\Branch\Branch;
use App\Models\Candidate\Candidate;
use App\Models\City\City;
use App\Models\Cluster\Cluster;
use App\Models\ContactUs;
use App\Models\District\District;
use App\Models\Download\Download;
use App\Models\Dropdown\Dropdown;
use App\Models\Facility\Facility;
use App\Models\Faq\Faq;
use App\Models\FileExtension;
use App\Models\Menu\Menu;
use App\Models\News\News;
use App\Models\Page\Page;
use App\Models\Party\Party;
use App\Models\Program\Program;
use App\Models\Section;
use App\Models\Seo\Seo;
use App\Models\Seo\SeoLink;
use App\Models\Slider\Slider;
use App\Models\SummerCamp\SummerCamp;
use App\Models\TeamMember\TeamMember;
use App\Models\Translation\Translation;
use App\Models\Translation\TranslationCategory;
use App\Models\Admin;
use App\Models\Visitor;
use App\Models\Voucher\Voucher;
use App\Policies\Activity\ActivityPolicy;
use App\Policies\AdminPolicy;
use App\Policies\Album\AlbumPolicy;
use App\Policies\AuditPolicy;
use App\Policies\Award\AwardPolicy;
use App\Policies\Block\BlockPolicy;
use App\Policies\BoothVoucher\BoothVoucherPolicy;
use App\Policies\Branch\BranchPolicy;
use App\Policies\Candidate\CandidatePolicy;
use App\Policies\City\CityPolicy;
use App\Policies\Cluster\ClusterPolicy;
use App\Policies\ContactUsPolicy;
use App\Policies\District\DistrictPolicy;
use App\Policies\Download\DownloadPolicy;
use App\Policies\Dropdown\DropdownPolicy;
use App\Policies\Facility\FacilityPolicy;
use App\Policies\Faq\FaqPolicy;
use App\Policies\FileExtensionPolicy;
use App\Policies\HeaderImage\HeaderImagePolicy;
use App\Policies\LanguageLinePolicy;
use App\Policies\MediaPolicy;
use App\Policies\Menu\MenuPolicy;
use App\Policies\News\NewsPolicy;
use App\Policies\Page\PagePolicy;
use App\Policies\Party\PartyPolicy;
use App\Policies\Program\ProgramPolicy;
use App\Policies\RolePolicy;
use App\Policies\SectionPolicy;
use App\Policies\Seo\SeoLinkPolicy;
use App\Policies\Slider\SliderPolicy;
use App\Policies\SummerCamp\SummerCampPolicy;
use App\Policies\TeamMember\TeamMemberPolicy;
use App\Policies\Translation\TranslationCategoryPolicy;
use App\Policies\Translation\TranslationPolicy;
use App\Policies\UserPolicy;
use App\Policies\VisitorPolicy;
use App\Policies\Voucher\VoucherPolicy;
use App\View\Components\Layout\HeaderImage;
use Awcodes\Curator\Models\Media;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
//    protected $policies = [
//        Block::class => BlockPolicy::class,
//        Branch::class => BranchPolicy::class,
//        City::class => CityPolicy::class,
//        District::class => DistrictPolicy::class,
//        Dropdown::class => DropdownPolicy::class,
//        Faq::class => FaqPolicy::class,
//        HeaderImage::class => HeaderImagePolicy::class,
//        Menu::class => MenuPolicy::class,
//        News::class  => NewsPolicy::class,
//        Page::class => PagePolicy::class,
//        Seo::class => SeoLinkPolicy::class,
//        Slider::class => SliderPolicy::class,
//        Translation::class => TranslationPolicy::class,
//        Audit::class => AuditPolicy::class,
//        ContactUs::class => ContactUsPolicy::class,
//        FileExtension::class => FileExtensionPolicy::class,
//        LanguageLinePolicy::class => LanguageLinePolicy::class,
//        Media::class => MediaPolicy::class,
//        Role::class => RolePolicy::class,
//        Section::class => SectionPolicy::class,
//        Admin::class => AdminPolicy::class,
//        Visitor::class => VisitorPolicy::class,
//        Voucher::class => VoucherPolicy::class,
//        BoothVoucher::class  => BoothVoucherPolicy::class,
//    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
