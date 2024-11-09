<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The students that belong to this section.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'section_student', 'section_id', 'student_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
    }

    /**
     * The teachers that belong to this section.
     */
    public function studentactivity()
    {
        return $this->belongsTo(studentactivity::class, 'studentactivity_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'section_subject', 'section_id', 'subject_id');
    }
    public function scopeForAuthenticatedUser(Builder $query)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'teacher') {
                // Filter to show only sections where user_id matches the authenticated user
                return $query->where('user_id', $user->id);
            }
        }

        return $query;
    }
    public function scopeForUser(Builder $query)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If the user is super_admin, return all records
            if ($user->role === 'super_admin') {
                return $query; // No filtering applied for super_admin
            }

            // If the user is a teacher, filter to only their assigned records
            if ($user->role === 'teacher') {
                return $query->where('user_id', $user->id);
            }
        }

        // If no authenticated user or an unsupported role, return no records for security
        return $query->whereRaw('0 = 1');
    }
}
