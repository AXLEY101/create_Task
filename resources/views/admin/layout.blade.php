<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ログイン機能付きタスク管理サービス　管理画面 @yield('title')</title>
    </head>
    <body>
        @auth('admin')
            <menu label="リンク">
                <a href="/admin/user/list">ユーザ一覧</a><br>
                管理画面機能1<br>
                管理画面機能2<br>
                管理画面機能3<br>
                管理画面機能4<br>
                <a href="/admin/logout">ログアウト</a><br>
                </menu>
        @endauth
        @yield('contets')
    </body>
</html>