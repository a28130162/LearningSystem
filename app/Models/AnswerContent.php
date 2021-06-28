<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_id',
        'question_id',
        'question_type',
        'case_information_id',
        'content',
    ];

    public function question()
    {
        return $this->morphTo();
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
