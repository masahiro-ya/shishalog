<?php
  session_start();
  require_once('../classes/UserLogic.php');
  var_dump($_POST);
  $mail = UserLogic::getUserByEmail($_POST['email']);
  $_SESSION['email'] = $mail['email'];
  if(isset($mail['email'])){
    $pass = bin2hex(random_bytes(5));
    $newpass = UserLogic::resetpass($pass, $mail['email']);
  }
?>
<!DOCTYPE html>
<head>
   <?php require '../public/head.php'; ?>
</head>
<html lang="ja">
  <body>
  <h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
    <img class="mb-4 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
    <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-5 py-5 rounded">
      <h3 style="text-align: center;">パスワードのリセットのメールを送信しました。</h2>
  <form action="reset.php" method="get">
    <input type="hidden" name="email" value="$_SESSION['email']">
    <input type="submit" value="パスワードを再発行する" class="btn btn-primary row col-4 offset-4">
  </form>
  </body>
</html>