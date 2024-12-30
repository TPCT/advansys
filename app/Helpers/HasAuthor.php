<?php
namespace App\Helpers;

use App\Models\Admin;
use Filament\Facades\Filament;

trait HasAuthor
{
    public static function bootHasAuthor(): void{
        parent::creating(function($query){
            if ($query->admin_id)
                return;
            $query->admin_id = auth()->user()->id;
        });
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}