<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
	protected $fillable = ['body'];
	
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public function isVoted() {
        return $this->hasOne('App\Vote')->where('user_id',  Auth::user()->id);
    }
}
