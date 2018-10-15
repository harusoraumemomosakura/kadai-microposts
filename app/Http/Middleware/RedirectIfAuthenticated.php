<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {//認証ミドルウェアの handle() は、ruotesの ['middleware' => ['auth']] が設定されたルーティングにアクセスされたときに毎回呼ばれる
        if (Auth::guard($guard)->check()) {//ログインしているかどうかを判断
            return redirect('/');//ログイン認証済みなのに、ログインページにアクセスしようとすると、リダイレクトされる。
        }

        return $next($request);
    }
}
