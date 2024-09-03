<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'section_id', 'grade'];

    // Relationship to student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship to section
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
