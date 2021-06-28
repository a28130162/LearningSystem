<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question_id',
        'user_id',
        'start_time',
        'end_time',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contents()
    {
        return $this->hasMany(AnswerContent::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
