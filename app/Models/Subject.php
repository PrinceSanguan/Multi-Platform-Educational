<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The sections that belong to this subject.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_subject', 'subject_id', 'section_id');
    }
}
