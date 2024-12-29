<?php

namespace App\Helpers;


trait HasStatus
{
    public function scopeActive($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', Utilities::PUBLISHED);
    }

    public static function bootHasStatus(){
        if (in_array(request()->segments()[0] ?? null, ['admin', 'livewire']) || in_array(request()->segments()[2] ?? null, ['merchant']))
            return;
        static::addGlobalScope('active', function ($builder) {
            $builder->where('status', Utilities::PUBLISHED);
        });
    }

    public static function getStatuses(): array
    {
        return [
            Utilities::PENDING => __("Pending"),
            Utilities::PUBLISHED => __("Published")
        ];
    }
}
