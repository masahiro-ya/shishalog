<?php
  session_start();
  require_once '../classes/search.php';
  require_once '../function.php';
  require_once '../classes/UserLogic.php';
	$conditions = filter_input(INPUT_GET, 'conditions');
	$select = filter_input(INPUT_GET, 'select');
  if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $UserData = search::searchparams($conditions, $select);
  }

?>
<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
  <link rel="stylesheet" type="text/css" href="../css/search.css">
</head>

<body>
	<?php require 'header.php'; ?>
		<div class="container mt-5">
			<?php if(!empty($conditions)): ?>
				<h3>"<?php echo $conditions; ?>" で "<?php echo $select; ?>"の検索結果</h3>
				<h3><strong><?php echo h(count($UserData)); ?></strong> 件</h3>
		  <?php elseif(empty($conditions)): ?>
		    <h3><?php echo $select; ?>で全件検索の結果</h3>
		    <h3><strong><?php echo h(count($UserData)); ?></strong> 件</h3>
		  <?php endif; ?>
			<div class="row">
				<?php if($select === '店舗'): ?>
					<?php foreach ($UserData as $key): ?>
						<div class="shop mx-3 mb-5">
							<?php if(!empty($key['shopImage'])): ?>
							  <img src="<?php echo h("{$key['shopImage']}") ?>" style="width: 100%; height: 200px;" alt="">
							<?php else: ?>
							  <img src="../img/no_image_yoko.jpg" alt="" style="width: 100%; height: 200px;" alt="">
							<?php endif; ?>

							<a href="detailshop.php?id=<?php echo h($key['shopId']) ?>" style="font-size: 20px;"><?php echo h("{$key['shopName']}") ?></a>
							<p>住所：<?php echo h("{$key['address']}") ?></p>
            </div>
					<?php endforeach; ?>
			  <?php endif; ?>
				<?php if($select === 'ユーザー'): ?>
					<?php foreach ($UserData as $key): ?>
						<div class="shop mx-3 mb-5">
						  <a href="detailuser.php?id=<?php echo h($key['userId']) ?>"><p><?php echo h("{$key['name']}") ?></p></a>
							<?php if(!empty($key['token'])): ?>
							  <p>自己紹介</p>
							  <p><?php echo h("{$key['token']}") ?></p>
							<?php else: ?>
							  <p>自己紹介文はまだありません。</p>
							<?php endif; ?>
							<p>誕生日：<?php echo h($key['birth']) ?></p>
							<p><?php echo UserLogic::get_user_count('follower', $key['userId']) ?> フォロワー</p>
							<p><?php echo UserLogic::get_user_count('follow', $key['userId']) ?> フォロー</p>
							<p>お気に入り数：<?php echo UserLogic::get_user_count('shopId', $key['userId']) ?></p>
            </div>
					<?php endforeach; ?>
			  <?php endif; ?>
		  </div>
	  </div>
<?php require("footer.php"); ?>
</body>