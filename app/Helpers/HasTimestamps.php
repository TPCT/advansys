<?php

namespace App\Helpers;


use Carbon\Carbon;
use DateTimeInterface;

trait HasTimestamps
{
    public static function bootHasTimestamps(){
        static::creating(function ($model) {
            $model->published_at ??= Carbon::now();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
