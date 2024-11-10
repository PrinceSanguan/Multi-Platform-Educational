<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class ArchMod extends Model
{
    use HasFactory, HasPanelShield, HasRoles, SoftDeletes;

    protected $table = 'modules';

    protected static function booted()
    {
        // Apply the "only trashed" scope to automatically filter for soft-deleted records
        static::addGlobalScope('onlyTrashed', function ($query) {
            $query->onlyTrashed();
        });
    }
}
