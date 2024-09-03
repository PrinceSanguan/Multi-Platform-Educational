<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'teacher_id'];

    // Relationship to teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relationship to students
    public function students()
    {
        return $this->hasMany(User::class);
    }

    // Relationship to grades
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
