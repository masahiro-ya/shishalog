<?php
  session_start();
  require_once("../function.php");
  require_once '../classes/UserLogic.php';
  $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
  unset($_SESSION['login_err']);


  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $err = [];
    $token = filter_input(INPUT_POST, 'csrf_token');
    //トークンがない場合、もしくは一致しない場合、処理を中止
    if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    	exit('不正なリクエスト');
    }

    unset($_SESSION['csrf_token']);
    if(!$user = filter_input(INPUT_POST, 'name')){
    	$err[] = 'ユーザー名は必須です。';
    }
    if(!$email = filter_input(INPUT_POST, 'email')){
    	$err[] = 'メールアドレスは必須です。';
    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
	  	$err[] = "正しいメールアドレスを入力してください。";
	  }

    $currentDate = date('Ymd');
    $birthday = str_replace("-", "", $_POST['birth']);
    $age = (($currentDate - $birthday) / 10000);
    if($age < 20){
      $err[] = '未成年は登録できません。';
    }

    $password = filter_input(INPUT_POST, 'password');
    if(!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i", $password)){
    	$err[] = '半角英数字をそれぞれ1種類以上含む8文字以上100文字以下のパスワードにしてください。';
    }
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    if($password !== $password_conf){
    	$err[] = '確認用パスワードと異なっています。';
    }
    if(count($err) === 0){
    	$user = UserLogic::createUser($_POST);
      $_SESSION['login_user'] = $user;
      header('Location: home.php');
  	  exit('新規作成しました');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <?php require 'head.php'; ?>
</head>
<h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
	<img class="mb-3 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
  <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-4 py-4 rounded">
  	<h3 style="text-align: center;">新規登録</h2>
  	<p><a href="login.php"class="col-2 offset-8">LOGIN</a></p>

   <?php if(isset($err)) : ?>
   	<?php foreach($err as $e) : ?>
   		<p><?php echo $e ?></p>
   	<?php endforeach ?>
  <?php endif ?>

  <?php if(isset($login_err)) : ?>
  	<?php echo $login_err; ?>
  <?php endif; ?>

  	<form action="signup.php" method="post">
  		<input type="text" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="name" placeholder="名前">
  		<input type="email" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="email" placeholder="メールアドレス">
  		<input type="date" id="datestart" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="birth" placeholder="生年月日">
  		<input type="password" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="password" placeholder="パスワード">
  		<input type="password" class="form-control row mb-3 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="password_conf" placeholder="パスワード確認">
  		<input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
  		<input type="submit" class="btn btn-primary row col-4 offset-4" value="新規登録">
  	</form>
  </div>
</html>

<script>
  // 現在の日付をYYYY-MM-DDの形式で取得
  function getCurrentYYYYMMDD() {

    var date = new Date();
    var y = date.getFullYear() - 20;
    var m = ("00" + (date.getMonth() + 1)).slice(-2);
    var d = ("00" + date.getDate()).slice(-2);
    return [y, m, d].join("-");
  }

  // 得られた日時を input の初期値として設定
  var dateControl = document.querySelector('input[type="date"]');
  dateControl.max = getCurrentYYYYMMDD();
</script>