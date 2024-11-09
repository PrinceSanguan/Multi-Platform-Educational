<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
 
class ArchMod extends Model
{
    
     use SoftDeletes, HasRoles, HasFactory, HasPanelShield;
    
     protected $table = 'modules'; // Points to the same table as the Module model
    
    protected static function booted()
    {
        // Apply the "only trashed" scope to automatically filter for soft-deleted records
        static::addGlobalScope('onlyTrashed', function ($query) {
            $query->onlyTrashed();
        });
    }
}
