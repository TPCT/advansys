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
        'image_id'
    ];

    public array $translatedAttributes = [
        'title', 'second_title', 'description', 'key_features', 'benefits', 'use_cases', 'why_us'
    ];
}
