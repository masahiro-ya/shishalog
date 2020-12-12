<?php
  session_start();
  require_once('../classes/UserLogic.php');
  $user = UserLogic::getUserByEmail($_SESSION['email']);
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $post = filter_input_array(INPUT_POST, $_POST);
    $err = [];
    $true = UserLogic::confirm($post['kari'], $user['sparepass']);
    if($true === false){
      $err['kari'] = '仮パスワードが一致しません。';
    }
    if(empty($post['newpass'])){
        $err['newpass'] = "パスワードを記入してください。";
    }
    elseif(!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i", $post['newpass'])){
      $err['newpass'] = '半角英数字をそれぞれ1種類以上含む8文字以上100文字以下のパスワードにしてください。';
    }

    if(empty($post['confirmpass'])){
      $err['confirmpass'] = "確認パスワードを記入してください。";
    }
    elseif($post['newpass'] !== $post['confirmpass']){
      $err['confirmpass'] = '確認用パスワードと異なっています。';
    }
    if(count($err) === 0){
      $user = UserLogic::remake($post['newpass'], $user['email']);
      if($user === true){
        header('Location: complete.php');
        exit('新規作成しました');
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <?php require '../public/head.php'; ?>
</head>
<body>
  <h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
    <img class="mb-4 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
    <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-5 py-5 rounded">
      <h3 style="text-align: center;">パスワード再発行</h2>
        <form action="reset.php" method="post">
          <?php if(isset($err['kari'])): ?>
            <p style="text-align: center; color: red;"><?php echo $err['kari'] ?></p>
          <?php endif; ?>
          <input type="text" name="kari" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" placeholder="仮パスワード">
          <?php if(isset($err['newpass'])): ?>
            <p style="text-align: center; color: red;"><?php echo $err['newpass'] ?></p>
          <?php endif; ?>
          <input type="text" name="newpass" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" placeholder="新しいパスワード">
          <?php if(isset($err['confirmpass'])): ?>
            <p style="text-align: center; color: red;"><?php echo $err['confirmpass'] ?></p>
          <?php endif; ?>
          <input type="text" name="confirmpass" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" placeholder="新しいパスワードの確認">
          <input type="submit" value="パスワード再発行" class="btn btn-primary row col-4 offset-4 mt-5">
      </form>
    </div>
</body>
</html>