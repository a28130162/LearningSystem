<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_paper_id',
        'name'
    ];

    public function project_contents()
    {
        return $this->hasMany(ProjectContent::class);
    }
}
