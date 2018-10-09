<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    public function first_user(){
        return $this->belongsTo(User::class, 'first_user_id');
    }

    //
    public function second_user(){
        return $this->belongsTo(User::class, 'second_user_id');
    }

    protected $fillable = [
        'first_user_id',  'second_user_id', 'first_user_goal', 'second_user_goal', 'first_user_score', 'second_user_score' , 'difference'
    ];
}
