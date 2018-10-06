<?php

session_start();

require_once 'common.php';
require_once 'twitteroauth/autoload.php';
require_once 'db.php';
require_once 'keywords/select.php'
require_once 'twitter_user/find_or_create.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//ユーザー情報をGET
$user = $connection->get("account/verify_credentials");
$twitter_user_id = $user->id;
find_or_create($mysqli, $user_id, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//$stmt = $mysqli->prepare ( 'select * from keywords where twitter_user_id = ?' );
//$stmt->bind_param('s', $user_id);
//$stmt->execute();
//$result = $stmt->get_result();
//$row = $result->fetch_assoc();
//$row = $stmt->fetch_assoc();
//$stmt->close();

$row = select($mysqli, $twitter_user_id)

$mysqli->close();
?>

<?php require 'header.php'; ?>

<body>
  <div class="container">

    <h2>設定</h2>

    <?php if ($row) { ?>
      <form action = "keywords/update.php" method = "get">
        <input type="hidden" name="id" value="<?php echo intval($row["id"]); ?>">
        <?php require "keywords/form.php" ?>
        <button type="submit" class="btn btn-primary">送信</button>
      </form>

    <?php }else{ ?>
      <form action = "keywords/create.php" method = "get">
        <?php require "keywords/form.php" ?>
        <button type="submit" class="btn btn-primary">送信</button>
      </form>
    <?php } ?>

  </div>
</body>
<script src="main.js"></script>
</html>
