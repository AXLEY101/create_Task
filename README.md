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
<p>コンソールで下記を入力してaws上のphp7.2を無効化し、7.4を有効化してください。</p>
<p>sudo amazon-linux-extras disable lamp-mariadb10.2-php7.2</p>
<p>sudo amazon-linux-extras enable php7.4</p>
<p>下記を入力し、php7.4=latest            enabled      [ =stable ]となっていれば設定できています。</p>
<p>sudo amazon-linux-extras list | grep php</p>
<p>この状態で「インストール準備」が整いましたので、</p>
<p>sudo yum clean metadata</p>
<p>sudo yum -y update</p>
<p>sudo yum -y install php</p>
<p></p>
<p>php -vと入力し下記のようになっていればOKです</p>
<p>php version</p>
<p>PHP 7.4.33 (cli) (built: Nov 19 2022 00:22:13) ( NTS )</p>
<p>Copyright (c) The PHP Group</p>
<p>Zend Engine v3.4.0, Copyright (c) Zend Technologies</p>
<p></p>
<p></p>
<p>動くことを確認したmariadbバージョン</p>
<p>mariadb version</p>
<p>MariaDB 10.5 database server</p>
<p></p>
<p></p>
<p>データベース設定</p>
<p>コンソールにて下記を入力し、mariadbを立ち上げます</p>
<p>sudo systemctl start mariadb</p>
<p>下記を入力し、初期設定をします</p>
<p>sudo mysql_secure_installation</p>
<p>Enter current password for root (enter for none): 「現在のパスワードの入力」は、現在は未設定なので、何も入力せずに Enter キーを押します。</p>
<p>Switch to unix_socket authentication [Y/n]  初期設定のままでよいので、何も入力せずに Enterキーを押します。</p>
<p>Change the root password? [Y/n]   「rootのパスワードの変更をしますか？」と聞かれます。Y を入力することで、変更できるようになります。ここはきちんと変更しておきましょう。
Y を入力します。(ここのパスワードで後ほどDBの設定をしますので覚えておいてください)</p>
<p>New password:</p>
<p>Re-enter new password:</p>
<p>上記のように２回聞かれるので、同じパスを二度入力してください　二度目は確認用です。</p>
<p></p>
<p>"Remove anonymous users? [Y/n]　「匿名ユーザの削除」の設定を聞かれます。
セキュリティ的に削除したほうがよいので、 Y を入力します。"</p>
<p>"Disallow root login remotely? [Y/n]　「リモートからのrootログインの禁止」の設定を聞かれます。
セキュリティ上、これも設定したほうがよいので、 Y を入力します。"</p>
<p>"Remove test database and access to it? [Y/n]　「test」というdatabaseの削除するかどうかを聞かれます。
残しておいてもよいのですが、後で改めてdatabaseの作成を行いますので、いったん削除しておきましょう。 Y を入力します。"</p>
<p>"Reload privilege tables now? [Y/n]　いろいろな設定を変更したので、「設定のリロード（再読込）」をしておきます。
Y を入力します。
ここまでで、必要なインストール作業が一段落しました。"</p>
<p></p>
<p></p>
<p></p>
<p>下記で、todolistというデータベースを作成し、日本語に対応したutf8mb4を設定します。</p>
<p>CREATE DATABASE todolist CHARACTER SET utf8mb4;</p>
<p></p>
<p>下記で、todouserというmariadbでログインできるユーザーを作成します。</p>
<p>CREATE USER 'todouser'@'localhost' IDENTIFIED BY '任意のパス';  (注意データベースのユーザのパスワードです。)</p>

<p>また、todouserには全権限を付与してください。</p>
<p>GRANT all ON todolist.* TO 'todouser'@'localhost';</p>
<p></p>
<p></p>

<p>.envファイルの設定</p>
<p>DB_DATABASE=todolist</p>
<p>DB_USERNAME=todouser</p>
<p>DB_PASSWORD=任意のパス　（注意　todouserというユーザーを作成した際のパスワードです。）</p>


<p></p>
<p></p>

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

<p>・web.phpにルーティングを用いた処理を記述しています。</p>
<p>・awsではロードバランサがsslに介入し、httpsをhttpと表示してしまうので、~/todolist/app/Http/Middleware/TrustProxies.phpを編集し、httpsと表示できるようにしています。</p>
<p>　　また、$headers = Request::HEADER_X_FORWARDED_PROTO としておりますので、Laravelがhttp とするかhttpsとするか判断できるようにしております。</>
<p>・各種Controllerにて、Modelを使った書き込み、formRequestクラスを用いたバリデート、auth.phpを利用したマルチ認証などを用いて書いております。</p>
<p>・バリデーションのルールにて、空白の処理に対してはTrimStringsクラスとConvertEmptyStringsToNullをコメントアウトしております。DBにnullが入らないようにと、空白の処理として変更</p>
<p>// \App\Http\Middleware\TrimStrings::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,</p>
<p>・Modelにて、各種テーブルの書き込みルールを記述しています。</p>
<p>・migration機能を利用するために、migrationに初期設定を記述しています。　DBに作られるテーブルの設定はここを確認してください。</p>
<p>・.blade.phpにて、展開されるファイルの記述をしています。　layout.blade.phpにテンプレートを記述していますので、雛形はこちらを確認してください。</p>