<?php

namespace App\Models\OurValue;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Helpers\WeightedModel;
use Illuminate\Database\Eloquent\Model;

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
