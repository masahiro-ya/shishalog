<?php
  require_once '../db_connect.php';

  function createAdmin($adminData)
  	{
  		$result = false;
       $sql = 'INSERT INTO admin (name, email, password) VALUES (?, ?, ?)';

       // ユーザーデータを配列に入れる処理
       $arr = [];
       $arr[] = $adminData['name'];
       $arr[] = $adminData['email'];
       $arr[] = password_hash($adminData['password'], PASSWORD_DEFAULT);

       try {
       	$stmt = connect()->prepare($sql);
       	$result = $stmt->execute($arr);
       	header('Location: ../admin/home.php');
        exit();
       } catch(\Exception $e){
        return $result;
       }
  	}

  function validationadmin($adminData){
  	if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $errmessage = [];
	  	$post = filter_input_array(INPUT_POST, $adminData);
	  	// 名前
	  	if(empty($post["name"])){
	  		$errmessage[] = "お名前は必須です。";
	  	}elseif(mb_strlen($post["name"]) > 10){
	  		$errmessage[] = "お名前は10文字以内で入力してください。";
	  	}
	  	// メールアドレス
	   	if(empty($post["email"])){
	  		$errmessage[] = "メールアドレスは必須です。";
	  	}elseif(!filter_var($post["email"], FILTER_VALIDATE_EMAIL)){
	  		$errmessage[] = "正しいメールアドレスを入力してください。";
	  	}
	  	// パスワード
	  	if(empty($post['password'])){
	  		$errmessage[] = "パスワードは必須です。";
	  	}elseif(!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i", $post['password'])){
	    	$errmessage[] = "半角英数字をそれぞれ1種類以上含む8文字以上100文字以下のパスワードにしてください。";
	    }
	    // パスワードを確認
	    if(empty($post['password_conf'])){
	    	$errmessage[] = "パスワードを確認してください。";
	    }elseif($post['password'] !== $post['password_conf']){
	    	$errmessage[] = '確認用パスワードと異なっています。';
	    }

      // エラーが無かったら登録へ
	  	if(count($errmessage) === 0){
	  		createAdmin($post);
	    }else{
	    // エラーがあればエラーメッセージを返す
		  	$errmessage = array($errmessage);
		  	return $errmessage;
	    }
    }
  }

  	/**
  	*ユーザーをemailから取得する
  	* param array $email
  	* return bool $result
  	*/
  	function login($email, $password){
  		// 結果
  		$result = false;
  		// ユーザーをemailから検索して取得
  		$user = getUserByEmail($email);

  		if(!$user){
  			$_SESSION['msg'] = 'emailが一致しません。';
  			return $result;
  		}

  		// パスワードの紹介
  		if(password_verify($password, $user['password'])){
  			// ログイン成功
  			session_regenerate_id(true);
  			$_SESSION['login_user'] = $user;
  			$result = true;
  			return $result;
  		}

  		$_SESSION['msg'] = 'パスワードが一致しません。';
  		return $result;
  	}
  	/**
  	*ユーザーをemailから取得する
  	* param array $email
  	* return array|bool $user|false
  	*/

  	/**
  	*ユーザーをemailから取得する
  	* param array $email
  	* return array|bool $user|false
  	*/
  	function getUserByEmail($email){
  		// SQLの準備
  		// SQLの実行
  		// SQLの結果を返す
       $sql = 'SELECT * FROM admin WHERE email = ?';

       // emailを配列に入れる
       $arr = [];
       $arr[] = $email;

       try {
       	$stmt = connect()->prepare($sql);
       	$stmt->execute($arr);
       	// SQLの結果を返す
       	$user = $stmt->fetch();
       	return $user;
       } catch(\Exception $e){
        return false;
       }
  	}

  	/**
  	* ログインチェック
  	* @param string void
  	* @return array bool $result
   	*/
  	function checkLogin(){
  		$result = false;
  		//セッションにログインユーザーが入ってなかったらfalse
  		if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
  			return $result = true;
  		}
  		return $result;
  	}

    function delete($object, $id){

      switch ($object) {

        case 'user':
        $sql ="UPDATE user SET deleteFlag = 1 WHERE userId = :id";
          break;

        case 'shop':
        $sql ="UPDATE shop SET deleteFlag = 1 WHERE shopId = :id";
          break;
      }
      $stmt = connect()->prepare($sql);
      $stmt->execute(array(':id' => $id));
      header('Location: ../admin/home.php');
      exit ('アカウントを削除しました！');
    }

    function inquiry($object){
      switch($object){
        case 'noreply':
        $sql = "SELECT * FROM inquiry WHERE replyFlag = 0";
          break;

        case 'okreply':
        $sql = "SELECT * FROM inquiry WHERE replyFlag = 1";
          break;

        case 'allreply':
        $sql = "SELECT * FROM inquiry";
          break;
      }
      $stmt = connect()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    function getinquiry($id){
       $sql = 'SELECT * FROM inquiry WHERE ID = :id';

       try {
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':id' => $id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
       } catch(\Exception $e){
        return $result;
       }
    }

    function validation($reply){
      if(empty($reply["reply"])){
        $err = "返信内容が記入されていません。。";
        return $err;
      }elseif(mb_strlen($reply["reply"]) > 255){
        $err = "お名前は250文字以内で入力してください。";
        return $err;
      }else{
        update($reply);
      }
    }

    function update($reply){
        $sql ="UPDATE inquiry SET reply = :reply, replyFlag = 1 WHERE ID = :id";
      try {
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':id' => $reply['id'], ':reply' => $reply['reply']));

        $message = $reply['name']."さま、この度はお問い合わせありがとうございました。\r\n"
                    ."お問い合わせ内容：".$reply['content']."\r\n"
                    ."お問い合わせに対する返信：".$reply['reply'];
        mail($reply['address'], 'お問い合わせありがとうございます。', $message);
        header('Location: ../admin/home.php');
        exit();
      } catch(\Exception $e){
        return $result;
      }
    }
?>