<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the user associated with the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'module_section', 'module_id', 'section_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'module_student', 'module_id', 'student_id')
            ->where('role', 'student');
    }

    public function getArchiveAttribute($value)
    {
        return storage_path('app/public/'.$value); // Adjust according to your storage configuration
    }
}