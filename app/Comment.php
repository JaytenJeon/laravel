<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'text', 'commentable_id', 'commentable_type', 'authorable_id', 'auhorable_type'
    ];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'id', 'parent_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
    public function authorable(){
        return $this->morphTo();
    }
}
