<?php

namespace App\Models\Service;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Service\SubService
 *
 * @property int $id
 * @property int $admin_id
 * @property int $service_id
 * @property int|null $image_id
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @method static \Illuminate\Database\Eloquent\Builder|SubService active()
 * @method static \Illuminate\Database\Eloquent\Builder|SubService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubService query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereUpdatedAt($value)
 * @property int $status
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @property-read \App\Models\Service\SubServiceLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service\SubServiceLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|SubService listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|SubService translated()
 * @method static \Illuminate\Database\Eloquent\Builder|SubService translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|SubService whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SubService withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class SubService extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \App\Helpers\HasTranslations, HasMedia, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, HasTimestamps, \App\Helpers\Translatable, ApiResponse;
    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public $translationModel = SubServiceLang::class;

    public array $upload_attributes = [
        'image_id', 'icon_id'
    ];

    public array $translatedAttributes = [
        'title', 'second_title', 'description', 'key_features', 'benefits', 'use_cases', 'why_us'
    ];
}
