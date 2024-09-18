<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'teacher_id', 'admin_id'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'thread_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}