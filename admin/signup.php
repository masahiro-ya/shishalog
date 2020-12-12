<?php
  session_start();
  require_once("../function.php");
  // $post = validation($_POST['form']);
  // $err = validation($err);
  require_once '../classes/adminLogic.php';
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $admin = validationadmin($_POST);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <?php require '../public/head.php'; ?>
</head>
<h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
	<img class="mb-3 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
  <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-4 py-4 rounded">
  	<h3 style="text-align: center;">新規登録</h2>
  	<p><a href="login.php"class="col-2 offset-8">LOGIN</a></p>

        <!-- 入力画面 -->
        <?php foreach ((array)$admin as $key) {
          if($key){
            echo '<div style="color:red;">';
            echo implode('<br>', $key);
            echo '</div>';
          }
        }
        ?>

  	<form action="signup.php" method="post">
  		<input type="text" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="name" placeholder="名前">
  		<input type="email" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="email" placeholder="メールアドレス">
  		<input type="password" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="password" placeholder="パスワード">
  		<input type="password" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="password_conf" placeholder="パスワード確認">
  		<input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
  		<input type="submit" class="btn btn-primary row col-4 offset-4" value="新規登録">
  	</form>
  	<div class="mt-4">
  	  	<p style="text-align: center;">SNSで新規登録する</p>

	  	  <div class="row justify-content-center">
		  	  <i class="fab fa-google mr-4 mt-1"></i>
		  	  <i class="fab fa-facebook mr-4 mt-1"></i>
		  	  <i class="fab fa-twitter mt-1"></i>
	  	  </div>
  	</div>
  </div>
</html>