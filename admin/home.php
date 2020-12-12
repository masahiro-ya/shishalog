<?php
  session_start();
  require_once '../classes/adminLogic.php';
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

	    $result = login($email, $password);

	    if(!$result){
				header('Location: login.php');
				return;
	    }
    }
?>

<head>
  <?php require 'head.php' ?>
</head>

<body>
	<?php require 'header.php'; ?>
	<div class="container">
		<h2 style="text-align: center;" class="my-5">検索する</h2>
	  <form action="search.php" method="get">
	  	<div class="row offset-2">
		  	<input type="text" name="conditions" placeholder="店名、地域、ユーザー名を入力" class="col-7 mr-3">
		    <select id="targetSelect" size="1" name="select" tabindex="-98" class="col-1">
		        <option>店舗</option>
		        <option>ユーザー</option>
		    </select>
	  	</div>
	  	<input type="submit" class="btn btn-primary row col-2 offset-5 mt-5" value="検索する">
	  </form>

      	<a href="shopcreate.php" class="row btn btn-primary row col-2 offset-5 mt-5">お店を登録する</a>

      	<a href="inquiry.php" class="row btn btn-primary row col-2 offset-5 mt-5">お問い合わせの返信</a>

	</div>
</body>