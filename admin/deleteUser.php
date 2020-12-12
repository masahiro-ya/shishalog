<?php
  require_once "../classes/adminLogic.php";
  $user = $_GET;

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
	  $userId = $_POST['userId'];
	  delete('user', $userId);
  }

?>

<head>
	<?php require 'head.php'; ?>
</head>

<body>
  <h2 class="row justify-content-center my-5">本当に退会しますか？</h2>
	<form action="deleteUser.php" method="post">
		<input type="hidden" name="userId" value="<?php echo $login_user['userId']; ?>">
		<input type="hidden" name="deleteFlag" value="1">
		<input type="submit" name="delete" value="退会する" class="btn btn-primary offset-5 col-2 mb-5">
	</form>
  <input type="button" value="戻る" onClick="history.back()" class="btn btn-primary offset-5 col-2 mb-5">
<!--

<h2>本当に退会しますか？</h2>
	<form action="deleteUser.php" method="post">
		<input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
		<input type="submit" name="delete" value="退会する">
	</form>
  <input type="button" value="戻る" onClick="history.back()">
</body> -->