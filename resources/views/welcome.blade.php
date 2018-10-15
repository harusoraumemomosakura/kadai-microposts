@extends('layouts.app')

@section('content')
  @if (Auth::check())<!--｢Auth::check()｣閲覧者がログイン中かどうかをチェック-->
    <?php $user = Auth::user(); ?><!--｢Auth::user()｣ログイン中のユーザを取得-->
    {{ $user->name }}
  @else
    <div class="center jumbotron">
        <div class="text-center">
            <h1>Welcome to the Microposts</h1>
            {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
        </div>
    </div>
  @endif
@endsection