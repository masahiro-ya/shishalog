<?php
  session_start();
  require_once '../classes/shopLogic.php';
  require_once '../classes/search.php';
  require_once '../classes/UserLogic.php';
  require_once '../function.php';
  $login_user = $_SESSION['login_user'];
  $id = $_GET['id'];
  $shopData = shopLogic::shopdetail($id);
  $getComment = shopLogic::getComment($shopData['shopId']);
  $latlng = shopLogic::get_gps_from_address($shopData['address']);

	$p_id = ''; //投稿ID
	$dbPostData = ''; //投稿内容
	$dbPostGoodNum = ''; //いいねの数
	$starAvg = '';

	// get送信がある場合
	if(!empty($shopData['shopId'])){
	    // 投稿IDのGETパラメータを取得
	    // DBから投稿データを取得
	    $dbPostData = shopLogic::getPostData($shopData['shopId']);
	    // DBからいいねの数を取得
	    $dbPostGoodNum = count(shopLogic::getGood($shopData['shopId']));
		  $starAvg = shopLogic::starAvg($shopData['shopId']);
		  $starAvg = round($starAvg, 2);
	}



?>
<!DOCTYPE html>
<html>
<head>
	  <?php require 'head.php'; ?>
	  <script type="text/javascript" src="../js/favorite.js"></script>
	  <script type="text/javascript" src="../js/validation.js"></script>
	  <script type="text/javascript" src="../js/comment.js"></script>
	  <script type="text/javascript" src="../js/star.js"></script>
	  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFRXd4vQhJZv0Y2jCSgtJVQ02PwHJsDoE"></script>
	  <script type="text/javascript" src="../js/googlemap.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/detail.css">
</head>
<body>
	<?php require 'header.php'; ?>

	<div class="container">
    <div class="row">
    	<div class="col-6 mt-5">
	      <h2><?php echo h($shopData['shopName']); ?></h2>
	      <div class="staravg">
	      	<?php if(empty(h($starAvg))): ?>
	      		<p>まだ評価されていません</p>
	      	<?php elseif(h($starAvg) < 1): ?>
	      	  <span style="color:#ffd700;"><i class="fas fa-star-half-alt"></i></span>
	      	<?php elseif(h($starAvg) < 1.5): ?>
	      		<span style="color:#ffd700;"><i class="fas fa-star"></i></span>
	      	<?php elseif(h($starAvg) < 2): ?>
	      	  <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
	      	<?php elseif(h($starAvg) < 2.5): ?>
	      	  <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
	      	<?php elseif(h($starAvg) < 3): ?>
	      	  <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
	      	<?php elseif(h($starAvg) < 3.5): ?>
	      	  <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
          <?php elseif(h($starAvg) < 4): ?>
            <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
          <?php elseif(h($starAvg) < 4.5): ?>
            <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
          <?php elseif(h($starAvg) < 5): ?>
            <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
          <?php elseif(h($starAvg) == 5): ?>
            <span style="color:#ffd700;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
	      	<?php endif ?>
          <h2 id="avg"><?php echo h($starAvg); ?></h2>
	      </div>
	    </div>
      <div class="like offset-1 col-5 mt-5">
      	<div class="row">
      		<p>お気に入り数：<?php echo $dbPostGoodNum; ?></p>
      		<a class="btn-primary offset-8 col-2" href="deleteShop.php?id=<?php echo $shopData['shopId'] ?>">強制退会</a>
      	</div>
        <h4>住所：<?php echo h($shopData['address']); ?></h4>
        <h4>開業日：<?php echo h($shopData['openDate']); ?></h4>
				<h5>開店時間：<?php echo h($shopData['openTime']); ?> 〜 <?php echo h($shopData['closeTime']); ?></h5>
				<h5>定休日：<?php echo h($shopData['holiday']); ?></h5>
      </div>
    </div>

      <?php if($shopData['shopImage']): ?>
	    <h2 style="text-align: center;" class="mt-5">お店の画像</h2>
	      <img src="<?php echo h($shopData['shopImage']); ?>" class="image col-6 offset-3 shopimage" alt="">
	  <?php elseif($shopData['shopImage'] == null): ?>
	  	  <h2 style="text-align: center;" class="mt-5">このお店はまだ画像を設定していません</h2>
	  	  <img src="../img/no_image_yoko.jpg" class="image col-6 offset-3 shopimage" alt="">
	  <?php endif ?>

	  <h2 style="text-align: center;">お店の場所</h2>

	  <div id="google-map" style="width: 100%; height: 500px;">
	  	<input type="hidden" class="lat" value="<?= $latlng['lat'] ?>">
	  	<input type="hidden" class="lng" value="<?= $latlng['lng'] ?>">
	  </div>

	  <div class="shopcomment">
	  	<table>
	  		<h2>このお店へのコメント</h2>
	  			<tr>
	  				<th><p id="newtitle"></p></th>
            <td><p id="newcomment"></p></td>
	  			</tr>
	  			<?php foreach ($getComment as $key): ?>
	  			<tr>
	  				<th><p><?php echo $key['title'] ?></p></th>
	  				<td><p><?php echo $key['body'] ?></p></td>
	  			</tr>
	  			<?php endforeach ?>
	  	</table>
    </div>
  </div>
</body>
</html>