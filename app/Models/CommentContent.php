<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_content_id',
        'comment_id',
        'score',
        'remark',
    ];

    public function comment()
    {
        return $this->BelongsTo(Comment::class);
    }


    public function question()
    {
        return $this->belongsTo(ProjectContent::class);
    }
}
