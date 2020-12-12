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
  $currentuser = $_GET;
  $user= UserLogic::get_user($currentuser['id']);
  $login_user = $_SESSION['login_user'];
  $shop = UserLogic::getFavorite($user['userId']);
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
  <link rel="stylesheet" type="text/css" href="../css/search.css">
</head>
<body>
	<?php require 'header.php'; ?>
  <div class="container mt-5">
    <h2 style="text-align: center;" class="my-5"><?php echo h($user['name']); ?>さんのお気に入り</h2>
    <div class="row">
        <?php foreach ($shop as $key): ?>
          <div class="oya">
            <div class="shops mx-3 mb-5">
              <a href="detailshop.php?id=<?php echo $key['shopId']; ?>" style="font-size: 20px;"><?php echo h("{$key['shopName']}") ?></a>
                <?php if($key['shopImage']): ?>
                  <img src="<?php echo h($key['shopImage']); ?>" alt="">
                <?php elseif($key['shopImage'] == null): ?>
                  <img src="../img/no_image_yoko.jpg" alt="">
                <?php endif ?>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
  </div>
</body>
</html>