<?php
  session_start();
  require_once '../classes/UserLogic.php';
  require_once '../classes/ShopLogic.php';
  require_once '../function.php';
  if(filter_input(INPUT_POST, 'logout')){
    UserLogic::logout();
  }

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
	  $err = [];
		if(!$email = filter_input(INPUT_POST, 'email')){
		  $err['email'] = 'メールアドレスは必須です。';
		}
		if(!$password = filter_input(INPUT_POST, 'password')){
		  $err['password'] = 'パスワードを記入してください。';
		}
		if(count($err) > 0){
			// エラーがあった場合は返す
			$_SESSION = $err;
			header('Location: login.php');
			return;
		}

	    $result = UserLogic::login($email, $password);

	    if(!$result){
				header('Location: login.php');
				return;
	    }
    }
  $rank = 1;
  $rank2 = 1;
  $top = ShopLogic::favorite();
  $star = ShopLogic::star();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/search.css">
	<?php require("head.php"); ?>
</head>
<body>
	<?php require 'header.php'; ?>
	<div class="container">
		<h2 style="text-align: center;" class="my-5">検索してみる</h2>
	  <form action="searchAll.php" method="get">
	  	<div class="row offset-2">
		  	<input type="text" name="conditions" placeholder="店名、地域、ユーザー名を入力" class="col-6 mr-3">
		    <select id="targetSelect" size="1" name="select" tabindex="-98" class="col-2">
		        <option>店舗</option>
		        <option>ユーザー</option>
		    </select>
	  	</div>
	  	<input type="submit" class="btn btn-primary row col-2 offset-5 mt-5" value="検索する">
	  </form>

      	<a href="shopcreate.php" class="row btn btn-primary row col-2 offset-5 mt-5">お店を登録する</a>

	  <h2 style="text-align: center;" class="my-5">Top５</h2>
		<select name="select" class="select">
		    <option value="favorite">お気に入り数順</option>
		    <option value="star">評価値順</option>
		</select>
		<div class="container mt-5">
			<div class="row iine">
					<?php foreach ($top as $key): ?>
					  <div class="oya">
					  	<h2><?php echo $rank++; ?>位</h2>
						<div class="shops mx-3 mb-5">
							<?php if(!empty($key['shopImage'])): ?>
							  <img src="<?php echo h("{$key['shopImage']}") ?>" style="width: 100%; height: 200px;" alt="">
							<?php else: ?>
							  <img src="../img/no_image_yoko.jpg" alt="" style="width: 100%; height: 200px;" alt="">
							<?php endif; ?>

							<a href="detailshop.php?id=<?php echo $key['shopId'] ?>" style="font-size: 20px;"><?php echo h("{$key['shopName']}") ?></a>
							<p style="font-size: 30px;">お気に入り数：<?php echo h("{$key['COUNT(s.shopId)']}") ?></p>
							<p>住所：<?php echo h("{$key['address']}") ?></p>
					     </div>
					  </div>
					<?php endforeach; ?>
            </div>
        </div>

		<div class="container mt-5">
			<div class="row star">
					<?php foreach ($star as $key): ?>
					  <div class="oya">
					  	<h2><?php echo $rank2++; ?>位</h2>
						<div class="shops mx-3 mb-5">
							<?php if(!empty($key['shopImage'])): ?>
							  <img src="<?php echo h("{$key['shopImage']}") ?>" style="width: 100%; height: 200px;" alt="">
							<?php else: ?>
							  <img src="../img/no_image_yoko.jpg" alt="" style="width: 100%; height: 200px;" alt="">
							<?php endif; ?>

							<a href="detailshop.php?id=<?php echo $key['shopId'] ?>" style="font-size: 20px;"><?php echo h("{$key['shopName']}") ?></a>
							<p style="font-size: 30px;">評価：<?php echo h(round("{$key['AVG(r.star)']}", 2)) ?></p>
							<p>住所：<?php echo h("{$key['address']}") ?></p>
					    </div>
					  </div>
					<?php endforeach; ?>
            </div>
        </div>
	</div>
	<?php require 'footer.php'; ?>
</body>
<script>
	$(".select").ready(function() {
    var category_val = $("#model").val();
        $('.star').css('display', 'none');
        $('.iine').css('display', 'flex');
    });

	$(".select").change(function() {
    var category_val = $(".select").val();
    if(category_val == "favorite") {
        $('.star').css('display', 'none');
        $('.iine').css('display', 'flex');
    }else if(category_val == "star") {
        $('.star').css('display', 'flex');
        $('.iine').css('display', 'none');
    }
});
</script>
</html>