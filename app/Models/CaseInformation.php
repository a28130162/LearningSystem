<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInformation extends Model
{
    use HasFactory;

    protected $table = 'case_informations';

    protected $fillable = [
        'title',
        'content',
        'video',
    ];

    public function questions()
    {
        return $this->morphToMany(Question::class, 'content', 'question_paragraph')->withTimestamps();
    }
}
