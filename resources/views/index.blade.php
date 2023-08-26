@extends('layout')
{{-- メインコンテンツ --}}
@section('contets')
    @if($errors->any())
        <div>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    @if(session('front.user_register_success') == true)
        ユーザー登録が成功しました。
    @endif
    
    

        <h1>ログイン</h1>
        <form action="/login" method="post">
            @csrf
            email:<input name="email" value="{{ old('email') }}"><br>
            パスワード:<input name="password" type="password"><br>
            <button>ログインする</button>
        </form>
        <a href="/user/register">ユーザー登録はこちらから</a>
@endsection