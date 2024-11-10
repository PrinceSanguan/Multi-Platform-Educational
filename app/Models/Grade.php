<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        'subject_id',
        'first_quarter',
        'second_quarter',
        'third_quarter',
        'fourth_quarter',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getAverageAttribute()
    {
        $total = $this->first_quarter + $this->second_quarter + $this->third_quarter + $this->fourth_quarter;

        return $total / 4;
    }
}
