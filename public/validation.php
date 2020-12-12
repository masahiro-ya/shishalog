<?php
function validation($post){
  // var_dump($post);
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // var_dump($post);

    if(empty($post["name"])){
      var_dump($post["name"]);
      $err[] = "ユーザー名は必須です。";
    }

    if(empty($post["email"])){
      var_dump($post["email"]);
      $err[] = "メールアドレスは必須です。";
    }elseif(!filter_var($post["email"], FILTER_VALIDATE_EMAIL)){
      $err[] = "正しいメールアドレスを入力してください。";
    }

    $currentDate = date('Y/m/d');
    $birthday = $post["birth"];

    $c = (int)date('Ymd', strtotime($currentDate));
    $b = (int)date('Ymd', strtotime($birthday));

    $age = (int)(($c - $b) / 10000);
    if($age < 20){
      $err[] = '未成年は登録できません。';
    }

    if(empty($post["password"])){
      $err[] = "パスワードを入力してください。";
    }elseif(!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i", $post["password"])){
      $err[] = '半角英数字をそれぞれ1種類以上含む8文字以上100文字以下のパスワードにしてください。';
    }

    if($post["password"] !== $post["password_conf"]){
    	$err[] = '確認用パスワードと異なっています。';
    }

    if(count($err) === 0){
    	header('Location: home.php');
    	exit('新規登録が完了しました！');
    }
  }
    else{
    $post["name"] = "";
    $post["email"] = "";
    $post["birth"] = "";
    $post["password"] = "";
    $post["password_conf"] = "";
  }
}

?>