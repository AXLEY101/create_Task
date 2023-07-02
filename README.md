<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## こちらのファイル群はLaravelでの動作を前提として記述しております。

<p>下記の環境で動作をチェックしています。

<p>・Laravelのcomposerを使ってインストール</p>
<p> composer create-project laravel/laravel ./todolist --prefer-dist</p>
<p>をコンソールに入力し、展開してください。　出来上がったtodolistにgithubに記載したファイル群を上書きで保存して、起動してください。　（cdでホームディレクトリに移動してから作業するとenvironmentディレクトリと同じ階層に出来上がります）</p>

<p>2023/5/20日時点のAWSはphp version 7.2なので変更が必要です。</p>

<p>php version</p>
<p>PHP 7.4.33 (cli) (built: Nov 19 2022 00:22:13) ( NTS )</p>
<p>Copyright (c) The PHP Group</p>
<p>Zend Engine v3.4.0, Copyright (c) Zend Technologies</p>

<p>mariadb version</p>
<p>MariaDB 10.5 database server</p>

<p>データベース設定</p>
<p>CREATE DATABASE todolist CHARACTER SET utf8mb4;</p>
<p>CREATE USER 'todouser'@'localhost' IDENTIFIED BY '任意のパス';  (注意データベースのユーザのパスワードです。)</p>

<p>.envファイルの設定</p>
<p>DB_DATABASE=todolist</p>
<p>DB_USERNAME=todouser</p>
<p>DB_PASSWORD=任意のパス　（注意　DB初期設定時の任意のパスワードです。）</p>

<p>また、todouserには全権限を付与してください。</p>
<p>GRANT all ON todolist.* TO 'todouser'@'localhost';</p>


<p>以上の設定が終わりましたら、コンソールにてマイグレーションを実行してください</p>
<p>php artisan migrate</p>

<p>管理者はseederで設定しております コンソールにて下記を入力してください</p>
<p>php artisan db:seed --class=AdminAuthUser</p>
<p>初期設定は、ログインID：hogehoge　パスワード：pass　としておりますので、ご確認ください。</p>



<p>・ユーザー登録機能</p>
<p>・ログイン機能</p>
<p>・ユーザー毎のタスク登録、テキスト記述、タスクの削除、編集機能</p>
<p>・優先順位でのソートによる一覧表示</p>
<p>・管理者用のログイン機能を記載しています。ドメイン/adminから動かす事ができます。</p>
<p>・管理者用の管理画面（現在登録件数、アカウント毎の入力一覧、削除など）</p>


<p>ポートフォリオなので、メール登録などは簡易になっています。</p>
<p>同じく、本来ならDBでの書き込みにてエラーが出たさい、ロールバックと共に、エラー内容を記述する挙動を取りますが、ここもエラー内容書き込みの処理を簡易処理にしています。</p>

<p>・web.phpにRoute::を用いた処理を記述しています。</p>
<p>・各種Controllerにて、Modelを使った書き込み、formRequestクラスを用いたバリデート、redirectでのページ遷移などの動作を記述しています。</p>
<p>・Modelにて、各種テーブルの書き込みルールを記述しています。</p>
<p>・migration機能を利用するために、migrationに初期設定を記述しています。　DBに作られるテーブルの設定はここを確認してください。</p>
<p>・.blade.phpにて、展開されるファイルの記述をしています。　layout.blade.phpにテンプレートを記述していますので、雛形はこちらを確認してください。</p>