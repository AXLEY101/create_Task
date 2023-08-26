<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## こちらのファイル群はLaravelでの動作を前提として記述しております。

<h1>下記の環境で動作をチェックしています。</h1>
<p>PHP 7.4.33</p>
<p>Laravel 8.83.27</p>
<p>mariadb 10.5</p>
<p>AWS Cloud9</p>

<h3>まずはPHPのバージョンを揃えます。</h3>
<p>sudo amazon-linux-extras disable lamp-mariadb10.2-php7.2</p>
<p>sudo amazon-linux-extras enable php7.4</p>
<p>この２つのコマンドを実行する事で、php7.2を無効化し、バージョン7.4を有効化</p>
<p>sudo amazon-linux-extras list | grep php</p>
<p>を入力すると確認画面が表示されます。</p>
<p>php7.4=latest            enabled      [ =stable ]</p>
<p>このように表示されていればOKです。（php7.4=latestにenabledと表示されていれば、正しく設定できている）</p>
<p>これで「インストールの"準備"」が整いました。続いてインストール</p>
<p>sudo yum clean metadata</p>
<p>sudo yum -y update</p>
<p>sudo yum -y install php</p>
<p>上記３つでインストール前にいらない情報を一旦クリアし、その後インストール</p>
<p>この時点で一旦php -vで確認。　すでにxdebug入ってるなら下記いらない。</p>
<p></p>
<p>php -v　で確認した時、xdebugの表示がなかった場合はこちらでインストールできます。（AWS2023/08/26現在の場合）</p>
<p>この時点では、xdebugの最新版はphpの８以上を要求しているためまだインストールできていません。php7.4用のxdebugを見繕ってやる必要があります。</p>
<p>sudo pecl channel-update pecl.php.net</p>
<p>上記でpeclを更新します</p>
<p>sudo pecl install xdebug-2.9.8</p>
<p>php7.4用のxdebugのインストール</p>
<p>インストール事態は上手くいっても、この状態でphp -v　を記載してもxdebugは表示されないはずです。</p>
<p>かといってsudo pecl install xdebug-2.9.8をもう一度入力しても</p>
<p>pecl/xdebug is already installed and is the same as the released version 2.9.8 というエラーがでるはず。</p>
<p>こちらは、すでにxdebugの2.9.8がインストールされていますという意味になります。</p>
<p>こういった場合はphp.iniを編集してやる必要があります。 php.iniは下記のコマンドで見つけれます</p>
<p>php --ini</p>
<p>こちらを入力すると、iniの一覧が出てきます。　この中にphp.iniがあるので、表示されているパスを参照して、php.iniを編集してください</p>
<p>AWSの場合、参照されたURLが表示されないはずです。　AWS上では、コンソールからエディタを起動し、編集してやる必要があります。</p>
<p>vimエディタ　もしくはnanoエディタが編集に使えます。（デフォルトの状態でコンソールから動きます。）</p>
<p>nanoはコンソール上で sudo nano [php.iniのパス]</p>
<p>vimはコンソール上で　sudo vim [php.iniのパス]</p>
<p>と入力すると、php.iniを開いてくれます。 vimは操作が少し特殊なので、下記に編集方法と画面の抜け方を記載します。</p>
<p>vimで編集を開始するには、iキーを押して挿入モードに入ります。</p>
<p>vimで編集が終わったら、Escキーを押してコマンドモードに戻ります。</p>
<p>:wqと入力してエンターキーを押すと、変更を保存してエディタを終了します。</p>
<p>もし変更せずに終了したい場合は、:q!と入力してエンターキーを押します。</p>
<p></p>
<p>php.iniは変更点が分かるように記載しましょう（基本的に、php.iniの末尾、コメントで入力情報を表記、拡張モジュールのセクションの中に記載する。　この三つの中のどれかがわかり易いとされています）</p>
<p>今回は、php.iniの末尾に記載します。下記を記載してください。</p>
<p>zend_extension="xdebug.so"</p>
<p>この一文を追加すると、xdebugが有効になり、 php -v コマンドでxdebugが表記されています。</p>
<p></p>
<p></p>
<h1>次にmariadbをインストールします。</h1>
<p>sudo amazon-linux-extras enable mariadb10.5</p>
<p>sudo yum -y install mariadb</p>
<p>この二つで、mariadbがインストールされるので</p>
<p>sudo systemctl status mariadb</p>
<p>でインストールされているか確認してください。</p>
<p>インストールされていたら、今度は</p>
<p>sudo systemctl start mariadb</p>
<p>と入力し、mariadbを起動します。　起動しているかは</p>
<p>sudo systemctl status mariadb</p>
<p>と入力してやると、今度はactive(running)となっています。　この状態ならデータベースとして動きます</p>
<p>次に初期設定をしてやります。</p>
<p>sudo mysql_secure_installation</p>
<p>こちらを入力するとEnter current password for root (enter for none): と出ます。「現在のパスワードの入力」は、現在は未設定なので、何も入力せずに Enter キーを押します。</p>
<p>次にSwitch to unix_socket authentication [Y/n]  とでます。初期設定のままでよいので、何も入力せずに Enterキーを押します。</p>
<p>次にChange the root password? [Y/n]   とでます。「rootのパスワードの変更をしますか？」と聞かれます。Y を入力することで、変更できるようになります。ここはきちんと変更しておきましょう。
Y を入力します。</p>
<p>次にNew password:</p>
<p>次にRe-enter new password:</p>
<p>と表示されます。　これはroot（一番権限の強いアカウント）のパスワードを入力します。 上のように２回聞かれます。</p>
<p>次にRemove anonymous users? [Y/n]　「匿名ユーザの削除」の設定を聞かれます。
セキュリティ的に削除したほうがよいので、 Y を入力します。</p>
<p>次にDisallow root login remotely? [Y/n]　「リモートからのrootログインの禁止」の設定を聞かれます。
セキュリティ上、これも設定したほうがよいので、 Y を入力します。</p>
<p>次にRemove test database and access to it? [Y/n]　「test」というdatabaseの削除するかどうかを聞かれます。
残しておいてもよいのですが、後で改めてdatabaseの作成を行いますので、いったん削除しておきましょう。 Y を入力します。</p>
<p>次にReload privilege tables now? [Y/n]　いろいろな設定を変更したので、「設定のリロード（再読込）」をしておきます。
Y を入力します。
ここまでで、必要なインストール作業が一段落しました。</p>
<p></p>
<p></p>
<h1>Laravelのインストール</h1>
<p>LaravelはPHP用のパッケージ管理システムcomposerを使ってインストールします。まずはcomposer自体をインストールします。</p>
<p>composerのインストール手順は</p>
<p>https://getcomposer.org/download/</p>
<p>の「Command-line installation」に記載されてる順に実行します。</p>
<p>コンソールでcd とだけ入力してホームディレクトリに移動してから作業します。</p>
<p>"php -r ""copy('https://getcomposer.org/installer', 'composer-setup.php');""
php -r ""if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;""
php composer-setup.php
php -r ""unlink('composer-setup.php');"""</p>
<p>サイトを訪問すると上のように書かれている部分を一行づつ実行します。　上から２行目は日にちが立つと変化するため、この記述通りにはならないことに注意。</p>
<p>入力できたら、lsコマンドで確認し、「composer.phar」というファイルが作成されていればＯＫ</p>
<p>このファイルを移動して、「どこからでも使える」ようにします。</p>
<p>sudo mv composer.phar /usr/local/bin/composer</p>
<p>使えるようになったかは type composerと入力すると</p>
<p>「composer is /usr/local/bin/composer」と記述されていればOK</p>
<p>これでcomposerコマンドを使う準備が整いました。</p>
<p>ついにインストールです</p>
<p>念のため、cdでホームディレクトリに移動してから作業してください</p>
<p>まずプロジェクトのクローンを作成します</p>
<p>git clone [リポジトリのURL] [任意のディレクトリ名]</p>
<p>上記のコマンドでgithubのURLからクローンを作成できます。　僕のポートフォリオは下記でOKです。</p>
<p>git clone https://github.com/AXLEY101/create_Task.git todolist</p>
<p>次にcomposerで依存関係が保存されていますので、コンポーザーをインストール</p>
<p>composer install</p>
<p></p>
<p>終わったら、次は.envファイルを設定しなおします。　このファイルはセキュリティの都合上githubに登録できません。</p>
<p>まずは、.envを作成します。　todolist直下にある.env.exampleをコピーして.envにリネームします。</p>
<p>ホームディレクトリでプロジェクトのクローンを作成しているなら下記のコマンドでコピーできます</p>
<p>cp ~/todolist/.env.example ~/todolist/.env</p>
<p>次に.envファイルを編集してやります。</p>
<p>開いたら下記のように書かれているはずです。</p>
<p>DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=</p>
<p>これを下記のように書き換えてください</p>
<p>DB_DATABASE=todolist
DB_USERNAME=todouser
DB_PASSWORD=（ここはデータベースにアクセスする際のパスワードになります。todouserに設定したパスワードを記載してください。）</p>
<p></p>
<p>次に、APP＿KEYを作成します。</p>
<p>php artisan key:generate</p>
<p>こちらを入力すると、.envファイルのAPP＿KEYに入力されます。</p>
<p></p>
<p>次に、データベースのtodouserに権限を渡してやります。</p>
<p>まず、データベースにrootでログインします</p>
<p>mysql -u root -p</p>
<p>MariaDB [(none)]>  ←のようになったらログイン成功　rootは全ての権限を持っているので、データベース作成とtodouserに権限を委譲する。</p>
<p>まずデータベースを作成する。 todolistという名前で、日本語に対応するためｍb4を選択</p>
<p>CREATE DATABASE todolist CHARACTER SET utf8mb4;</p>
<p>次にtodouserを作成　パスワードを与える。　（今回はポートフォリオのためパスワードをrootと同じにしています。）</p>
<p>CREATE USER 'todouser'@'localhost' IDENTIFIED BY ' (先ほど.envファイルに記述したDB_PASSWORDと同じにしてください)';</p>
<p>次に、todouserにtodolistデータベースの全ての権限を委譲</p>
<p>GRANT all ON todolist.* TO 'todouser'@'localhost';</p>
<p></p>
<p>ここまで来たら、マイグレーションが動くようになります。</p>
<p>php artisan migrateでマイグレーションを動かします。</p>
<p>管理者をシーダーで記載していますので、シーダーを動かして管理者を登録します</p>
<p>php artisan db:seed --class=AdminAuthUser</p>
<p>これで、動く状態が出来上がりました。 Laravelの仮想サーバーを動かして挙動を確認しましょう。</p>
<p>cd でtodolistディレクトリに移動しコンソールで下記を記述します。</p>
<p>php artisan serve --port=8080</p>
<p>新しいコンソールを開き、今度はデータベースを起動してやります。</p>
<p>sudo systemctl start mariadb</p>
<p></p>
<p>起動を確認したら、「ドメイン/」にアクセスすると、タスク管理システムが動いています。</p>
<p></p>
<p>初期設定は、ログインID：hogehoge　パスワード：pass　としておりますので、ご確認ください。</p>
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