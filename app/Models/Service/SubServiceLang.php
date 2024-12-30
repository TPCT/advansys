<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Service\SubServiceLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $second_title
 * @property string $description
 * @property string|null $key_features
 * @property string|null $use_cases
 * @property string|null $benefits
 * @property string|null $why_us
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereKeyFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereSecondTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereUseCases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubServiceLang whereWhyUs($value)
 * @mixin \Eloquent
 */
class SubServiceLang extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "sub_services_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
