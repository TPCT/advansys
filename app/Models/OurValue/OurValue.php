<?php

namespace App\Models\OurValue;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OurValue\OurValue
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property-read \Awcodes\Curator\Models\Media|null $icon
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @property-read \App\Models\OurValue\OurValueLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OurValue\OurValueLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue active()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue translated()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValue withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class OurValue extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \App\Helpers\HasTranslations, HasMedia, HasAuthor, HasStatus, \OwenIt\Auditing\Auditable, HasTimestamps, \App\Helpers\Translatable, ApiResponse;

    public $translationModel = OurValueLang::class;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public array $translatedAttributes = [
        'title'
    ];

    public array $upload_attributes = [
        'image_id'
    ];
}
