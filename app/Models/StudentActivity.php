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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_activity_user', 'activity_id', 'user_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
    }
}
