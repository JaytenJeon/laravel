<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'title', 'text', 'postable_id', 'postable_type'
    ];
    protected  $dates = ['deleted_at'];

    public  function postable(){
        return $this->morphTo();
    }
}
