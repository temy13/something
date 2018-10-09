<?php
##############################################
### 初期設定

//セッションスタート
session_start();

//文字セット
header("Content-type: text/html; charset=utf-8");

//セッション変数を全て解除
$_SESSION = 	array();
$_COOKIE = 		array();

//クッキー削除
setcookie("PHPSESSID", '', time() - 1800, '/');

//セッションを破棄する
session_destroy();
?>
<?php require 'header.php'; ?>

<body>
  <div class="container">
    <h2>Twitter アカウント ログアウト</h2>

    <?php
    echo "ログアウトしました。";
    echo "<a href='http://rtbot.ne.je/login.php'>ログインへ</a>";
    ?>
  </div>
</body>
</html>
