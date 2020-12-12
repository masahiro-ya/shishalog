<?php
  require_once '../classes/search.php';
  require_once '../function.php';
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
			<div class="row">
				<?php if($select === '店舗'): ?>
					<?php foreach ($UserData as $key): ?>
						<div class="shops mx-3 mb-5">
							<?php if(!empty($key['shopImage'])): ?>
							  <img src="<?php echo h("{$key['shopImage']}") ?>" style="width: 100%; height: 200px;" alt="">
							<?php else: ?>
								<img src="../img/no_image_yoko.jpg" alt="" style="width: 100%; height: 200px;" alt="">
							<?php endif; ?>

							<a href="detailShop.php?id=<?php echo $key['shopId'] ?>" style="font-size: 20px;"><?php echo h("{$key['shopName']}") ?></a>
							<p>住所：<?php echo h("{$key['address']}") ?></p>
            </div>
					<?php endforeach; ?>
			  <?php endif; ?>

				<?php if($select === 'ユーザー'): ?>
					<?php foreach ($UserData as $key): ?>
						<div class="shops mx-3 mb-5">
						  <a href="detailUser.php?id=<?php echo $key['userId'] ?>" style="font-size: 20px;"><?php echo h("{$key['name']}") ?></a>
            </div>
					<?php endforeach; ?>
			  <?php endif; ?>
		  </div>
	  </div>
</body>