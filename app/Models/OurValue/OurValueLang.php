<?php

namespace App\Models\OurValue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\OurValue\OurValueLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OurValueLang whereTitle($value)
 * @mixin \Eloquent
 */
class OurValueLang extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "our_values_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
