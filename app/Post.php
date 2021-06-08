<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo('App\User');

    }

    public function likes() {
        return $this->hasMany('App\Like');
    }
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function isLikedByLoggedInUser()
    {
        return $this->likes->where('user_id', auth()->user()->id)->isEmpty() ? false : true;
    }
    public function isCommentedByLoggedInUser()
    {
        return $this->comments->where('user_id', auth()->user()->id)->isEmpty() ? false : true;
    }

    public function heartAnimation()
    {
        return $this->likes->where('user_id', auth()->user()->id)->isEmpty() ? "fa fa-heart-o heart" : "fa fa-heart heart";
    }
}