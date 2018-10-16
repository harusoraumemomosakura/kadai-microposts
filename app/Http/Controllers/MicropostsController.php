<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;//追加

class MicropostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $data =[]; 
        if (\Auth::check()) { //ログイン認証を確認
            $user = \Auth::user();//ログイン中のユーザを取得
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);//ログイン中のユーザのmicropostsを取得
            
            $data = [//$dataへ配列
              'user' => $user,
              'microposts' => $microposts,
            ];
            $data += $this->counts($user);
            return view('users.show', $data);
        }else {
            return view('welcome');
        }
    }
     
    public function store(Request $request)//「新規登録処理」
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return redirect()->back();
    }
}
