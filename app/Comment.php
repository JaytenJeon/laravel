<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;
    protected  $dates = ['deleted_at'];

    protected $fillable = [
        'text', 'commentable_id', 'commentable_type', 'authorable_id', 'auhorable_type'
    ];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->withTrashed();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'id', 'parent_id')->withTrashed();
    }

    public function commentable()
    {
        return $this->morphTo();
    }
    public function authorable(){
        return $this->morphTo();
    }
}
