<?php
  session_start();
  require_once '../function.php';
  require_once '../classes/UserLogic.php';
  $user = $_SESSION['login_user'];
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $err = [];
    if(!$user = filter_input(INPUT_POST, 'name')){
      $err[] = 'ユーザー名は必須です。';
    }
    if(!$email = filter_input(INPUT_POST, 'email')){
      $err[] = 'メールアドレスは必須です。';
    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $err[] = "正しいメールアドレスを入力してください。";
    }

    if(count($err) === 0){
      $user = UserLogic::editUser($_POST);
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
</head>
<body>
  <?php require 'header.php'; ?>
  	<form action="edituser.php" method="post" class="mt-5">
  		<input type="text" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="name" placeholder="名前" value="<?php echo h($user['name']); ?>">
  		<input type="email" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="email" placeholder="メールアドレス" value="<?php echo h($user['email']); ?>">
  		<textarea name="content" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="token"><?php echo h($user['token']); ?></textarea>
  		<input type="submit" class="btn btn-primary row col-2 offset-5 mt-5" value="会員情報編集">
  	</form>
  </div>
</body>
</html>
