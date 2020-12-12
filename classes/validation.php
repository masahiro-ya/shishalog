<?php
  function validation($post){
	  if($_SERVER['REQUEST_METHOD'] === 'POST'){
	  	session_start();
	  	$post = filter_input_array(INPUT_POST, $_POST);
	  	// 名前
	  	if(empty($post["name"])){
	  		$errmessage[] = "お名前は必須です。";
	  	}elseif(mb_strlen($post["name"]) > 10){
	  		$errmessage[] = "お名前は10文字以内で入力してください。";
	  	}
	  	// メールアドレス
	   	if(empty($post["mail"])){
	  		$errmessage[] = "メールアドレスは必須です。";
	  	}elseif(!filter_var($post["mail"], FILTER_VALIDATE_EMAIL)){
	  		$errmessage[] = "正しいメールアドレスを入力してください。";
	  	}
	  	// タイトル
	  	if(empty($post["title"])){
	  		$errmessage[] = "タイトルは必須です。";
	  	}elseif(mb_strlen($post["name"]) > 15){
	  		$errmessage[] = "タイトルは15文字以内で入力してください。";
	  	}
	  	// 内容
	  	if(empty($post["content"])){
	  		$errmessage[] = "タイトルは必須です。";
	  	}elseif(mb_strlen($post["content"]) > 300){
	  		$errmessage[] = "内容は300文字以内で入力してください。";
	  	}

	  	// エラーが無かったら確認画面へ
	  	if(!is_array($errmessage)||count($errmessage === 0)){
	  	  $_SESSION = $post;
	  	  header('Location:confirm.php');
	  	  exit();
	    }
	  	$errmessage = array($errmessage);
	  	return $errmessage;
	  }
  }
?>