<?php
  session_start();
  $err = $_SESSION;

  $_SESSION = array();
  session_destroy();

?>
<!DOCTYPE html>
<html>
<head>
  <?php require '../public/head.php'; ?>
</head>
<h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
	<img class="mb-4 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
  <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-5 py-5 rounded">
  	<h3 style="text-align: center;">ログイン</h2>
  	<p><a href="signup.php"class="col-2 offset-8">SIGN UP</a></p>
  	<?php if(isset($err['msg'])) : ?>
  		<p><?php echo $err['msg']; ?></p>
  	<?php endif; ?>
  	<form action="home.php" method="post">
  		<input type="email" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="email" placeholder="メールアドレス">
  		  <?php if(isset($err['email'])) : ?>
  		  	<p><?php echo $err['email']; ?></p>
  		  <?php endif; ?>
  		<input type="text" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="password" placeholder="パスワード">
  		  <?php if(isset($err['password'])) : ?>
  		  	<p><?php echo $err['password']; ?></p>
  		  <?php endif; ?>
  		<input type="submit" class="btn btn-primary row col-4 offset-4" value="ログイン">
  	</form>
  </div>
</html>