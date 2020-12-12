<?php
  session_start();
  require_once '../classes/UserLogic.php';
	$current_user = UserLogic::get_user($_GET['id']);
  $follow = UserLogic::get_user_count('follow', $current_user['userId']);
  $follower = UserLogic::get_user_count('follower', $current_user['userId']);
  $favorite = UserLogic::get_user_count('shopId', $current_user['userId']);
?>
<head>
	<?php require 'head.php'; ?>
	<script type="text/javascript" src="../js/follow.js"></script>
</head>

<body>
	<?php require 'header.php'; ?>

	<div class="container">
		<div class="row mt-5">
			<h3 class="col-2"><?= $current_user['name'] ?></h3>
			<a class="btn-primary offset-8 col-2" href="deleteUser.php?id=<?php echo $current_user['userId'] ?>">強制退会</a>
		</div>
		<p>誕生日：<?= $current_user['birth'] ?></p>
	</div>
      <h4 style="text-align: center;"><?php echo $follower ?>  フォロワー</h4>
		  <h4 style="text-align: center;"><?php echo $follow ?>  フォロー</h4>
		  <h4 style="text-align: center;">お気に入り：<?php echo $favorite ?></h4>

		<h3 class="mt-5" style="text-align: center;">自己紹介</h3>
		<h5 class="mt-3" style="text-align: center;"><?= $current_user['token'] ?></h5>
	</div>
</body>