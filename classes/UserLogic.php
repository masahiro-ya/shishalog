<?php
  require_once '../db_connect.php';
  require_once '../vendor/autoload.php';

  class UserLogic
  {
  	/**
  	*ユーザー登録をする
  	* param array $userData
  	* return bool $result
  	*/
  	public static function createUser($userData)
  	{
       $result = false;
       $conn = connect();
       $sql = 'INSERT INTO user (name, email, birth, password) VALUES (?, ?, ?, ?)';

       // ユーザーデータを配列に入れる処理
       $arr = [];
       $arr[] = $userData['name'];
       $arr[] = $userData['email'];
       $arr[] = $userData['birth'];
       $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

       try {
       	$stmt = $conn->prepare($sql);
       	$stmt->execute($arr);
        $user = $conn->lastInsertId();
        $user = self::usersearch($user);
        self::fakeuser();
        return $user;

       } catch(\Exception $e){
        exit($e);
       }
  	}

    public static function usersearch($user){
      try{
         $sql = 'SELECT * FROM user WHERE userId = :userId';
         $stmt = connect()->prepare($sql);
         $stmt->execute(array(':userId' => $user));
         return $stmt->fetch();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }

    public static function fakeuser(){
      $faker = Faker\Factory::create('ja_JP');
        for ($i = 0; $i < 10; $i++) {
          $shopName = $faker->company;
          $address = mb_substr($faker->address, 9);
          $openDate = $faker->date;
          $openTime = $faker->time;
          $closeTime = $faker->time;
          $sql =
            "INSERT INTO shop (
              shopName,
              address,
              openDate,
              openTime,
              closeTime
              )
            VALUES (
              :shopName,
              :address,
              :openDate,
              :openTime,
              :closeTime
            )";
          $stmt = connect()->prepare($sql);
          $stmt->bindValue(':shopName', $shopName);
          $stmt->bindValue(':address', $address);
          $stmt->bindValue(':openDate', $openDate);
          $stmt->bindValue(':openTime', $openTime);
          $stmt->bindValue(':closeTime', $closeTime);
          $stmt->execute();
        }
      for ($i = 0; $i < 10; $i++) {
          $password = $faker->password;
          $name = $faker->name;
          $email = $faker->email;
          $birth = $faker->dateTimeBetween('-80 years', '-20years')->format('Y-m-d');
          $token = $faker->realText(20);
          $sql =
            "INSERT INTO user (
              password,
              name,
              email,
              birth,
              token
              )
            VALUES (
              :password,
              :name,
              :email,
              :birth,
              :token
            )";
          $stmt = connect()->prepare($sql);
          $stmt->bindValue(':password', $password);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':birth', $birth);
          $stmt->bindValue(':token', $token);
          $stmt->execute();
      }
    }

  	public static function deleteUser($user)
  	{
       $sql = "UPDATE user SET deleteFlag = :deleteFlag WHERE userId = :userId";
       $dbh = connect();
       $dbh->beginTransaction();
       try {
         // ユーザーデータを配列に入れる処理
         $stmt = $dbh->prepare($sql);
         $stmt->bindValue(':deleteFlag', $user['deleteFlag'], PDO::PARAM_INT);
         $stmt->bindValue(':userId', $user['userId'], PDO::PARAM_INT);
       	 $stmt->execute();
         $dbh->commit();
         session_destroy();
         header('Location: ../public/signup.php');
         exit('退会しました');
       } catch(\Exception $e){
        exit($e);
       }
  	}
  	/**
  	*ユーザーをemailから取得する
  	* param array $email
  	* return bool $result
  	*/
  	public static function login($email, $password){
  		// 結果
  		$result = false;
  		// ユーザーをemailから検索して取得
  		$user = self::getUserByEmail($email);

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
      var_dump($password, $user['password']);
  		$_SESSION['msg'] = $password;
  		return $result;
  	}
  	/**
  	*ユーザーをemailから取得する
  	* param array $email
  	* return array|bool $user|false
  	*/
  	public static function getUserByEmail($email){
  		// SQLの準備
  		// SQLの実行
  		// SQLの結果を返す
       $sql = 'SELECT * FROM user WHERE email = ? AND deleteFlag = 0';

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
  	public static function checkLogin(){
  		$result = false;
  		//セッションにログインユーザーが入ってなかったらfalse
  		if(isset($_SESSION['login_user']) && $_SESSION['login_user']['userId'] > 0 && $_SESSION['login_user']['deleteFlag'] == 0) {
  			return $result = true;
  		}
  		return $result;
  	}

  	/** ログアウト処理
  	*/

  	 public static function logout(){
  	 	$_SESSION = array();
  	 	session_destroy();
   	 }

     /** お店の作成をする
    */

    public static function shopSave($shop, $save_path){
      $result = False;

      $sql = "INSERT INTO shop (shopName, address, openDate, openTime, closeTime, holiday, shopImage) VALUE (?, ?, ?, ?, ?, ?, ?)";

      try {
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $shop['shopName']);
        $stmt->bindValue(2, $shop['address']);
        $stmt->bindValue(3, $shop['openDate']);
        $stmt->bindValue(4, $shop['openTime']);
        $stmt->bindValue(5, $shop['closeTime']);
        $stmt->bindValue(6, $shop['holiday']);
        $stmt->bindValue(7, $save_path);
        $result = $stmt->execute();
        return $result;
      } catch (\Exception $e) {
        echo $e->getMessage();
        return $result;
      }
    }

    function get_user($user_id){
        try {
          $sql = "SELECT *
                  FROM user
                  WHERE userId = :id";
          $stmt = connect()->prepare($sql);
          $stmt->execute(array(':id' => $user_id));
          return $stmt->fetch();
        } catch (\Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
          set_flash('error',ERR_MSG1);
        }
      }

    function check_follow($follow_user,$follower_user){
      try{
        $sql = "SELECT follow_id,follower_id
                FROM relation
                WHERE :follower_id = follower_id AND :follow_id = follow_id";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':follow_id' => $follow_user,
                             ':follower_id' => $follower_user));
        return  $stmt->fetch();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }

    function get_user_count($object,$user_id){

      switch ($object) {

        case 'follow':
        $sql ="SELECT COUNT(r.follower_id)
               FROM relation AS r LEFT JOIN user AS u
               ON u.userId = r.follow_id
               WHERE r.follower_id = :id AND u.deleteFlag = 0";
          break;

        case 'follower':
        $sql ="SELECT COUNT(r.follow_id)
               FROM relation r LEFT JOIN user AS u
               ON u.userId = r.follower_id
               WHERE r.follow_id = :id AND u.deleteFlag = 0";
          break;

        case 'shopId':
        $sql = "SELECT COUNT(s.shopId)
        FROM shop AS s LEFT JOIN favorite AS f ON s.shopId= f.shopId
        WHERE f.userId = :id";
          break;
      }
      $stmt = connect()->prepare($sql);
      $stmt->execute(array(':id' => $user_id));
      return $stmt->fetchColumn();
    }

    function searchrelation($object,$user_id){
      switch ($object) {

        case 'follow':
        $sql ="SELECT *
               FROM user AS u LEFT JOIN relation AS r
               ON u.userId = r.follow_id
               WHERE r.follower_id = :id AND u.deleteFlag = 0";
          break;

        case 'follower':
        $sql ="SELECT *
               FROM user AS u LEFT JOIN relation AS r
               ON u.userId = r.follower_id
               WHERE r.follow_id = :id AND u.deleteFlag = 0";
          break;

        case 'shopId':
        $sql = "SELECT COUNT(s.shopId)
        FROM shop AS s LEFT JOIN favorite AS f ON s.shopId= f.shopId
        WHERE f.userId = :id";
          break;
      }
      $stmt = connect()->prepare($sql);
      $stmt->execute(array(':id' => $user_id));
      return $stmt->fetchAll();
    }

    function count_follower($follower){
      try{
        $sql = "SELECT u.name FROM user AS u LEFT JOIN relation AS r
                ON u.userId = r.follow_id
                WHERE :follow_id = follow_id";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':follow_id' => $follower));
        return $stmt->fetchAll();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }
    function searchfollower($follower){
      try{
        $sql = "SELECT * FROM user AS u LEFT JOIN relation AS r ON u.userId = r.follow_id WHERE r.follower_id = :follow_id AND u.deleteFlag = 0";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':follow_id' => $follower['id']));
        return $stmt->fetchAll();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }


    function count_follow($follow){
      try{
        $sql = "SELECT * FROM relation WHERE :follow_id = follower_id";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':follow_id' => $follow));
        return $stmt->fetchAll();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }
    function searchfollow($follower){
      try{
        $sql = "SELECT * FROM user AS u LEFT JOIN relation AS r ON u.userId = r.follower_id WHERE r.follow_id = :follow_id AND u.deleteFlag = 0";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':follow_id' => $follower));
        return $stmt->fetchAll();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }

    function getFavorite($userId){
      try{
        $sql = "SELECT * FROM shop AS s LEFT JOIN favorite AS f ON s.shopId= f.shopId WHERE f.userId = :userId";
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':userId' => $userId));
        return $stmt->fetchAll();
      }catch (\Exception $e){
        exit("Can't insert ERROR!".$e -> getMessage());
      }
    }
    public static function inquiry($userData)
    {
       $result = false;
       $conn = connect();
       $sql = 'INSERT INTO inquiry (name, address, content, title) VALUES (?, ?, ?, ?)';

       // ユーザーデータを配列に入れる処理
       $arr = [];
       $arr[] = $userData['name'];
       $arr[] = $userData['mail'];
       $arr[] = $userData['content'];
       $arr[] = $userData['title'];;

       try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr);
        $message = $userData['name']."さま、この度はお問い合わせありがとうございます。\r\n"
                    ."お問い合わせ内容：".$userData['content']."\r\n"
                    ."お返事には３営業日ほどいただきます。";
        mail($userData['mail'], 'お問い合わせありがとうございます。', $message);
       } catch(\Exception $e){
        exit($e);
       }
    }

    public static function resetpass($pass, $address){

        $sql = "UPDATE user SET sparepass = :pass WHERE email = :email";
        $dbh = connect();
        $dbh->beginTransaction();
      try{
         $stmt = $dbh->prepare($sql);
         $stmt->bindValue(':pass', password_hash($pass, PASSWORD_DEFAULT));
         $stmt->bindValue(':email', $address);
         $stmt->execute();
         $dbh->commit();

         $message = "仮パスワードです。\r\n". $pass . "\r\n";
         mail($address, '仮パスワードです。', $message);
         $ph = password_hash($pass, PASSWORD_DEFAULT);
         $line = '"' . $address . '","' . $ph . '"';
         return $ph;
      } catch(\Exception $e){
        exit($e);
       }
    }

    public static function confirm($kari, $user){
      $result = false;
      if(password_verify($kari, $user)){
        // ログイン成功
        $result = true;
        return $result;
      }
      return $result;
    }

    public static function remake($newpass, $email){
        $result = false;
        $sql = "UPDATE user SET password = :pass WHERE email = :email";
        $dbh = connect();
        $dbh->beginTransaction();
      try{
         $stmt = $dbh->prepare($sql);
         $stmt->bindValue(':pass', password_hash($newpass, PASSWORD_DEFAULT));
         $stmt->bindValue(':email', $email);
         $stmt->execute();
         $dbh->commit();
         $result = true;
         return $result;
      } catch(\Exception $e){
          exit($e);
      }
    }

    public static function edituser($edit){
      var_dump($edit);
        $sql = "UPDATE user SET name = :name, email = :email, token = :token WHERE email = :email";
        $dbh = connect();
        $dbh->beginTransaction();
      try{
         $stmt = $dbh->prepare($sql);
         $stmt->bindValue(':name', $edit['name']);
         $stmt->bindValue(':email', $edit['email']);
         $stmt->bindValue(':token', $edit['content']);
         $stmt->execute();
         $dbh->commit();
         header('Location: ../public/home.php');
         exit ("会員情報を編集しました！");
      } catch(\Exception $e){
        exit($e);
       }
    }
  }
?>