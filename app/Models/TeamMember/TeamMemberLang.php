<?php

namespace App\Models\TeamMember;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\TeamMember\TeamMemberLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMemberLang whereTitle($value)
 * @mixin \Eloquent
 */
class TeamMemberLang extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "team_members_lang";
    public $timestamps = false;
    protected $guarded = ['id'];
}
