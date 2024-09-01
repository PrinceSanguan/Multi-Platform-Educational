<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function students()
    {
        return $this->belongsToMany(User::class, 'section_user', 'section_id', 'user_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
    }

    public function activities()
    {
        return $this->hasMany(StudentActivity::class);
    }


}