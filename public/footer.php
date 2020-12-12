<?php
  session_start();
  require_once '../classes/UserLogic.php';
  $login_user = $_SESSION['login_user'];

?>

<body>
	<div class="container-fluid header">
		<div class="row py-5">
			<div class="col-3">
				<img src="../img/logo.png" alt="" width="80" height="80">
			</div>

			<div class="col-4 offset-5 mt-4">
				<a href="inquiry.php" class="btn btn-light mr-5">お問い合わせ</a>
				<?php if(isset($_SESSION['login_user'])): ?>
				  <a href="delete.php?id=<?php echo $login_user['userId'] ?>" name="delete" class="btn btn-light">退会する</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>