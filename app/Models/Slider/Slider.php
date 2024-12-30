<?php

namespace App\Models\Slider;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Slider\Slider
 *
 * @property int $id
 * @property int $user_id
 * @property string $category
 * @property string $slug
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slider\SliderSlide> $slides
 * @property-read int|null $slides_count
 * @property-read \App\Models\Slider\SliderLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slider\SliderLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\Admin $user
 * @method static \Illuminate\Database\Eloquent\Builder|Slider active()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider withTranslation(?string $locale = null)
 * @property int $admin_id
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereAdminId($value)
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property-read Category|null $slider_category
 * @property-read SubCategory|null $slider_sub_category
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSubCategoryId($value)
 * @mixin \Eloquent
 */

class Slider extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasAuthor, Auditable, HasStatus, ApiResponse;

    public const HOMEPAGE_HERO_SLIDER = "Homepage Hero Slider";
    public const HOMEPAGE_PROJECTS_SLIDER = "Homepage Projects Slider";
    public const HOMEPAGE_FEEDBACK_SLIDER = "Homepage Feedback Slider";
    public const HOMEPAGE_PARTNERS_SLIDER = "Homepage Partners Slider";


    public static function getCategories(){
        return [
            self::HOMEPAGE_HERO_SLIDER => __(self::HOMEPAGE_HERO_SLIDER),
            self::HOMEPAGE_PROJECTS_SLIDER => __(self::HOMEPAGE_PROJECTS_SLIDER),
            self::HOMEPAGE_FEEDBACK_SLIDER => __(self::HOMEPAGE_FEEDBACK_SLIDER),
            self::HOMEPAGE_PARTNERS_SLIDER => __(self::HOMEPAGE_PARTNERS_SLIDER),
        ];
    }

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function slides(){
        return $this->hasMany(SliderSlide::class)->orderBy('id');
    }
}
