<?php
// セッション開始
session_start();
//セッションIDが盗み取られることによるセッションハイジャックを防ぐために使用する関数
session_regenerate_id(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //フォームのボタンが押されたら、POSTされたデータを各変数に格納
    
    require_once('common.php');

    $post=sanitize($_POST);

    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // トークンの生成（CSRF対策）
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;

    try{
        $dsn='mysql:dbname=portfolio;host=localhost;charset=utf8';
        $user='root';
        $password='';
        $dbh=new PDO($dsn, $user, $password);
        //データベースに接続した後にオプションを指定するには PDO::setAttributeメソッドを使用
        //PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql='INSERT INTO form(name, email, message) VALUES(?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data[]=$name;
        $data[]=$email;
        $data[]=$message;
        $stmt->execute($data);

        $dbh=null;

        // $compFlg=1;
        header(("location: ../contact.html?&compFlg=1"));
        exit;

    }
    catch(Exception $e)
    {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

} else {
    //フォームボタン以外からこのページにアクセスした場合（URL直接入力など）、トップページに戻る
    header(("location: main.html"));
    exit;
}
?>

<!-- <input type="hidden" name="token" value="<?php echo $token; ?>"> -->


<!--  
CSRF対策
CSRF（クロスサイト・リクエストフォージェリ） とは、
掲示板や問い合わせフォームなどを処理するWebアプリケーションが、
本来拒否すべき他サイトからのリクエストを受信し、
ユーザーの意図しない処理を実行させるサイバー攻撃です。
悪意のある攻撃者はインターネット上のどこかに罠サイトを設置し、
その罠サイトを踏んだ利用者は意図しないリクエストを発信してしまいます。
これを利用して、攻撃者は第三者のIPアドレスから犯罪予告などのメールを送信することが可能になります。
これを防ぐためには、トークンによる認証が有効です。
-->
<!--  
XSS（クロスサイト・スクリプティング） とは、
悪意のある閲覧者がHTMLの<script>タグなどで有害な動作をするスクリプトを書き入れ、プログラムを操作するサイバー攻撃です。
対策としては、htmlspecialchars関数を使用してHTMLタグをエスケープすることです。
htmlspecialchars関数は、HTMLにおいて特別な働きを持つ文字について、特別な働きを失わせる関数です。
例えば、<を&lt;に、>を&rt;に変換し、ブラウザがこれらの文字をそのまま画面に表示できるようにします。
-->
