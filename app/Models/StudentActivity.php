<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'status', 'section_id'];

    // Relationship to the section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Scope for filtering by type
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Method to toggle visibility status
    public function toggleVisibility()
    {
        $this->status = $this->status === 'visible' ? 'hidden' : 'visible';
        $this->save();
    }
}
