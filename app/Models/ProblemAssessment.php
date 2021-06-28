<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    public function questions()
    {
        return $this->morphToMany(Question::class, 'content', 'question_paragraph')->withTimestamps();
    }

    public function answers()
    {
        return $this->morphMany(AnswerContent::class, 'question');
    }
}
