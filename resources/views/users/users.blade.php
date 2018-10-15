@if (count($users) > 0)
<ul class="media-list">
@foreach ($users as $user)
    <li class="media">
        <div class="media-left"><!--アバター表示-->
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {{ $user->name }}<!--ユーザー名表示-->
            </div>
            <div>
                <p>{!! link_to_route('users.show', 'View profile', ['id' => $user->id]) !!}</p><!--users.showへのリンク-->
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $users->render() !!} <!--ページネーション-->
@endif