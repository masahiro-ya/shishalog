<?php
  session_start();
  require_once '../classes/UserLogic.php';
  $login_user = $_SESSION['login_user'];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
	  $user = $_POST;
	  var_dump($user);
	  UserLogic::deleteUser($user);
  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>shishalog</title>
	<link rel="stylesheet" type="text/css" href="../css/base.css">
	<!-- フォントオーサム -->
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

	<!-- ブートストラップ -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- ここまで -->
	<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body>
	<?php require 'header.php'; ?>
		<h2 class="row justify-content-center my-5">本当に退会しますか？</h2>
		<form action="delete.php" method="post">
			<input type="hidden" name="userId" value="<?php echo $login_user['userId']; ?>">
			<input type="hidden" name="deleteFlag" value="1">
			<input type="submit" name="delete" value="退会する" class="btn btn-primary offset-5 col-2 mb-5">
		</form>
  <input type="button" value="戻る" onClick="history.back()" class="btn btn-primary offset-5 col-2 mb-5">

  <?php require 'footer.php'; ?>
</body>
</html>