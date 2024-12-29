<?php

namespace App\Models\Translation;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Translation\TranslationLang
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $language
 * @property string|null $content
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationLang whereParentId($value)
 * @mixin \Eloquent
 */
class TranslationLang extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "translations_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
