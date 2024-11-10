<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentActivity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'user_id', 'section_id', 'image_path'];

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
                $query->where('name', 'student'); // Filter users by role 'student'
            })
            ->withTimestamps(); // Enable timestamps on the pivot table
    }

    public function scopeForAuthenticatedUser(Builder $query)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'student') {
                // Filter to show only sections where user_id matches the authenticated user
                return $query->where('user_id', $user->id);
            }
        }

        return $query;
    }
}
