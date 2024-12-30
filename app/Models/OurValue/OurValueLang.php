<?php

namespace App\Models\OurValue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OurValueLang extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "our_values_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}
