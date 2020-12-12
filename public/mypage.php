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
  $follow = UserLogic::get_user_count('follow', $login_user['userId']);
  $follower = UserLogic::get_user_count('follower', $login_user['userId']);
  $favorite = UserLogic::get_user_count('shopId', $login_user['userId']);
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
</head>
<body>
	<?php require 'header.php'; ?>
      <div class="container my-5">
        <h2 style="text-align: center;" class="mb-3">マイページ</h2>
        <h2 style="text-align: center;" class="mb-3">自己紹介文</h2>
        <h4 style="text-align: center;" class="mb-3"><?php echo h($login_user['token']) ?></h4>
        <a href="edituser.php?id=<?php echo h($login_user['userId']) ?>">会員情報編集</a>
      	  <h4 style="text-align: center;">ログインユーザー：<?php echo h($login_user['name']) ?></p>
      	  <h4 style="text-align: center;">フォロワー一覧：<a href="myfollower.php?id=<?php echo h($login_user['userId']) ?>"><?php echo $follower ?></h4></a>
      	  <h4 style="text-align: center;">フォロー一覧：<a href="myfollow.php?id=<?php echo h($login_user['userId']) ?>"><?php echo $follow ?></h4></a>
      	  <h4 style="text-align: center;">お気に入り一覧：<a href="myfavorite.php?id=<?php echo h($login_user['userId']) ?>"><?php echo $favorite ?></h4></a>
      </div>
  <?php require 'footer.php'; ?>
</body>
</html>