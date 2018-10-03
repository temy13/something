<?php

session_start();

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//ユーザー情報をGET
$user = $connection->get("account/verify_credentials");

// $word = $_GET['keyword'];
// echo $word;
// echo $user->id;

?>

<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="main.js"></script>
<title>タイトル</title>
<meta http-equiv="Content-Style-Type" content="text/css">
</head>
<body>
  <div class="container">

    <h2>設定</h2>

    <?php if (False) { ?>
      あほ

    <?php }else{ ?>
      <form action = "mypage.php" method = "get">
        <div class="form-group">
          <label>指定するキーワード</label>
          <input type = "text" name ="keyword" class="form-control" placeholder="キーワード">
        </div>
        <div class="form-group">
          <label>RTするツイートの数</label>
          <input type = "number" name ="number" class="form-control" max=10 min = 1 value=1>
        </div>
        <div class="form-group">
          <label>タイミング</label>
          <label class="radio-inline"><input type="radio" name="timing" value="auto" class="timing-form-btn" checked onChange="timeSet('auto')">数分おき</label>
          <label class="radio-inline"><input type="radio" name="timing" value="manual" class="timing-form-btn" onChange="timeSet('manual')">時間指定</label>
        </div>
        <div class="form-group timing-auto timing-set">
          <input type = "time" name ="auto_time" class="" >分おきにRT
        </div>
        <div class="form-group timing-manual timing-set">
          <?php for ($i=0; $i<=4; $i++) { ?>
            <div><input type = "time" name="manual_time[]" class="" >にRT</div>
          <?php } ?>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapseExample">
            もっと指定する
          </button>
          <div class="collapse" id="collapse1">
            <?php for ($i=0; $i<=10; $i++) { ?>
              <div><input type = "time" name="manual_time[]" class="" >にRT</div>
            <?php } ?>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseExample">
              もっと指定する
            </button>
            <div class="collapse" id="collapse2">
              <?php for ($i=0; $i<=10; $i++) { ?>
                <div><input type = "time" name="manual_time[]" class="" >にRT</div>
              <?php } ?>
            </div>
          </div>

        </div>
        <button type="submit" class="btn btn-primary">送信</button>
      </form>
    <?php } ?>

  </div>
</body>
</html>
