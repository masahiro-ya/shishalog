	<div class="container-fluid header">
		<div class="row py-5">
			<div class="col-3">
				<a href="home.php"><img src="../img/logo.png" alt="" width="80" height="80"></a>
			</div>
			<?php if(isset($_SESSION['login_user'])): ?>
				<div class="col-4 offset-5 mt-4 buttn">
					<a href="shopcreate.php" class="mr-3 btn btn-light">お店登録</a>
					<a href="mypage.php" class="mr-3 btn btn-light">マイページ</a>

					<form action="home.php" method="POST">
					  <input type="submit" name="logout" class="btn btn-light" value="ログアウト">
					</form>
				</div>
			<?php elseif(!isset($_SESSION['login_user'])): ?>
				<div class="col-4 offset-5 mt-4 buttn">
					<a href="home.php" class="mr-3 btn btn-light">検索画面</a>
					<a href="signup.php" class="mr-3 btn btn-light">新規登録</a>
				</div>
			<?php endif; ?>
		</div>
	</div>