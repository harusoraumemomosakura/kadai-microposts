<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];//createで使う準備
    
    public function user()//単数形にする
    {
        return $this->belongsTo(User::class);//Micropost のインスタンスが所属している唯一の User を取得できる
    }
}
