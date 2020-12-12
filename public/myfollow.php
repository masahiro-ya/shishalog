<?php
  session_start();
  require_once '../classes/UserLogic.php';
  require_once '../function.php';
  //ログインしているか判定し、していなかったら新規登録画面へ遷移
  $result = UserLogic::checkLogin();
  if(!$result){
  	$_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
  	header('Location: signup.php');
  	return;
  }
  $login_user = $_SESSION['login_user'];

  $login_user = UserLogic::searchrelation('follow', $login_user['userId']);
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
  <link rel="stylesheet" type="text/css" href="../css/search.css">
</head>
<body>
	<?php require 'header.php'; ?>

  <h2 style="text-align: center;">あなたのフォロー一覧</h2>
  <div class="container mt-5">
    <div class="row">
          <?php foreach ((array)$login_user as $key): ?>
            <div class="shop mx-3 mb-5">
              <a href="detailuser.php?id=<?php echo $key['userId'] ?>" style="font-size: 20px;"><?php echo h("{$key['name']}") ?></a>
              <?php if(!empty($key['token'])): ?>
                <p><?php echo h("{$key['token']}") ?></p>
              <?php else: ?>
                <img src="../img/no_image_yoko.jpg" alt="" style="width: 100%; height: 200px;" alt="">
                <p>自己紹介文はまだありません。</p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
    </div>
  </div>
</body>
</html>