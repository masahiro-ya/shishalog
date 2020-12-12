<?php
  session_start();

  require_once "../db_connect.php";
  require_once "../classes/UserLogic.php";
// ログインチェック
  $result = UserLogic::checkLogin($_SESSION['login_user']);
  if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
    header('Location: signup.php');
    return;
  }
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $shop = $_POST;
    $file = $_FILES['img'];
    $filename = basename($file['name']);
    $tmp_path = $file['tmp_name'];
    $file_err = $file['error'];
    $filesize = $file['size'];
    $save_filename = date('YmdHis').$filename;
    $upload_dir = '../images/';
    $save_path = $upload_dir.$save_filename;
    if($filesize > 1048576 || $file_err == 2){
      echo "ファイルサイズは１MB未満にしてください。";
    }

    // 拡張子は画像形式かどうか
    $allow_ext = array('jpg', 'jpeg', 'png');
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array(strtolower($file_ext), $allow_ext)){
    	echo "画像を添付してください。";
    }

    if(is_uploaded_file($tmp_path)){
  	  if(move_uploaded_file($tmp_path, $save_path)){
  	  	echo $filename . 'をアップしました。';
  	  	// データベースに保存(ファイルパスのみ)
  	  	$result = UserLogic::shopSave($shop, $save_path);

  	  	if($result) {
  	  		echo "保存しました";
  	  	}else{
  	  		echo "保存に失敗しました";
  	  	}
  	  }else{
  	  	echo 'ファイルを保存できませんでした。';
      }
    }else{
    	echo 'ファイルが選択されていません。';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'head.php'; ?>
</head>
<body>
	<?php require 'header.php'; ?>
	<div class="container">
		<h2 style="text-align: center;" class="my-5">お店登録</h2>
	  <form enctype="multipart/form-data" action="shopcreate.php" method="post">
	  	<div class="create">
		  <input type="text" name="shopName" placeholder="店名" class="row col-8 offset-2 mb-5">
      <input type="text" name="address" placeholder="お店の住所" class="row col-8 offset-2 mb-5">
      <input type="text" name="openDate" placeholder="お店がオープンした日" class="row col-8 offset-2 mb-5">
      <div class="row mb-5">
      	<input type="text" name="openTime" placeholder="開店時間" class="offset-2 col-4">  〜  <input type="text" name="closeTime" placeholder="閉店時間" class="col-4">
      </div>
      <select name="holiday" placeholder="定休日" class="row col-8 offset-2 mb-5">
          <option value="日曜日">日曜日</option>
          <option value="月曜日">月曜日</option>
          <option value="火曜日">火曜日</option>
          <option value="水曜日">水曜日</option>
          <option value="木曜日">木曜日</option>
          <option value="金曜日">金曜日</option>
          <option value="土曜日">土曜日</option>
      </select>
      <input type="hidden" name="MAX_FILE_SIZE" value="1058476">
      <input name="img" type="file" accept="image/*" class="row col-8 offset-2 mb-5">
	  	</div>
	  	<input type="submit" class="btn btn-primary row col-2 offset-5 my-5" value="登録する">
	  </form>

	</div>
	<?php require 'footer.php'; ?>
</body>
</html>