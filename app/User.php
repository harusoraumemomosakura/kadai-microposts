<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [//｢$fillable｣ は想定していないパラメータへのデータ代入を防ぎかつ、一気にデータを代入するために利用
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()//複数形
    {
        return $this->hasMany(Micropost::class);//User のインスタンスが自分の Microposts を取得できる
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
    
    
    //多対多の関係belongsToMany()
    public function followings()//User がフォローしている User 達
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }//$user->followings で $user がフォローしている User 達を取得
    
    public function followers()//User をフォローしている User 達
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }//$user->followers で$user をフォローしている User 達を取得
    
    
    //follow(), unfollow()
    public function follow($userId)//follow関数の定義
    {
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {
        // 既にフォローしている、または自分自身の場合は何もしない
        return false;
    } else {
        // 未フォローまたは自分自身でなければフォローする
        $this->followings()->attach($userId);
        return true;
    }
    }

    public function unfollow($userId)//unfollow関数の定義
    {
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist && !$its_me) {
        // 既にフォローしているかつ、自分自身でなければフォローを外す
        $this->followings()->detach($userId);
        return true;
    } else {
        // 未フォローかつ、自分自身であれば何もしない
        return false;
    }
    }

    public function is_following($userId) {//is_following関数の定義
    return $this->followings()->where('follow_id', $userId)->exists();
   }
   
   public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }
    
}
