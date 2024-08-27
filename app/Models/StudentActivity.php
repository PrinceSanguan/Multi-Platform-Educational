<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    // Scope for filtering visible activities
    public function scopeVisible($query)
    {
        return $query->where('status', 'visible');
    }
}
