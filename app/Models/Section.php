<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The students that belong to this section.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'section_user', 'section_id', 'user_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
    }

    /**
     * The teachers that belong to this section.
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'section_user', 'section_id', 'user_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            });
    }
}
