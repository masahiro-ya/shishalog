<?php
  session_start();
  require_once '../classes/UserLogic.php';
	$current_user = UserLogic::get_user($_GET['id']);
	$profile_user = UserLogic::get_user($_SESSION['login_user']);
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
			<!-- フォロー機能 -->
			<form action="#" method="post" class="offset-6 col-4">
		    <input type="hidden" class="current_user_id" value="<?= $current_user['userId'] ?>">
		    <input type="hidden" class="follow" name="follow_user_id" value="<?= $_SESSION['login_user']['userId'] ?>">
		    <?php if (UserLogic::check_follow($current_user['userId'],$_SESSION['login_user']['userId'])): ?>
		      <button class="follow_btn border_white btn btn-primary following follow" type="button" name="follow">フォロー中</button>
		    <?php else: ?>
		      <button class="follow_btn border_white btn nofollow" type="button" name="follow">フォロー</button>
		    <?php endif; ?>
			</form>
			<!-- ここまで -->
		</div>
		<p>誕生日：<?= $current_user['birth'] ?></p>
	</div>
      <h4 class="count" style="text-align: center;"><a href="followerAll.php?id=<?php echo $current_user['userId'] ?>"><?php echo $follower ?></a>  フォロワー</h4>
		  <h4 style="text-align: center;"><a href="followAll.php?id=<?php echo $current_user['userId'] ?>"><?php echo $follow ?></a>  フォロー</h4>
		  <h4 style="text-align: center;">お気に入り：<a href="favoriteAll.php?id=<?php echo $current_user['userId'] ?>"><?php echo $favorite ?></a></h4>

		<h3 class="mt-5" style="text-align: center;">自己紹介</h3>
		<h5 class="mt-3" style="text-align: center;"><?= $current_user['token'] ?></h5>
	</div>
  <?php require("footer.php"); ?>
</body>