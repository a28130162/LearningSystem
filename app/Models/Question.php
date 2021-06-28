<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_paper_id',
        'subject_id',
        'user_id',
        'name',
        'quiz_time',
        'status',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment_paper()
    {
        return $this->belongsTo(CommentPaper::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function question_descriptions()
    {
        return $this->morphedByMany(QuestionDescription::class, 'content', 'question_paragraph')->withTimestamps();
    }

    public function case_informations()
    {
        return $this->morphedByMany(CaseInformation::class, 'content', 'question_paragraph')->withTimestamps();
    }

    public function problem_assessments()
    {
        return $this->morphedByMany(ProblemAssessment::class, 'content', 'question_paragraph')->withTimestamps();
    }

    public function problem_solveds()
    {
        return $this->morphedByMany(ProblemSolved::class, 'content', 'question_paragraph')->withTimestamps();
    }
}
