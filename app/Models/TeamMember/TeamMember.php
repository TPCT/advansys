<?php

namespace App\Models\TeamMember;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\WeightedModel;
use App\Models\Dropdown\Dropdown;
use Filament\Tables\Columns\Concerns\HasWeight;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\TeamMember\TeamMember
 *
 * @property int $id
 * @property int $user_id
 * @property int $weight
 * @property int|null $image_id
 * @property int $dropdown_id
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $author
 * @property-read Dropdown $dropdown
 * @property-read \App\Models\TeamMember\TeamMemberLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TeamMember\TeamMemberLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember active()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember translated()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember translations()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember withTranslation(?string $locale = null)
 * @property int $admin_id
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMember whereAdminId($value)
 * @mixin \Eloquent
 */
class TeamMember extends WeightedModel implements \OwenIt\Auditing\Contracts\Auditable
{
    use \App\Helpers\Translatable, HasAuthor, HasStatus, Auditable, \App\Helpers\HasTranslations, HasWeight, ApiResponse, HasTimestamps;

    public $translationModel = TeamMemberLang::class;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public array $upload_attributes = [
        'image_id'
    ];

    public array $translatedAttributes = [
        'title', 'description'
    ];
}