<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_project_id',
        'dimension',
        'level_content',
    ];

    public function comments()
    {
        return $this->hasMany(CommentContent::class);
    }
}
