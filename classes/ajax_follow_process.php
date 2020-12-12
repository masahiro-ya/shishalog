<?php
  session_start();
  require_once '../db_connect.php';
  require_once 'userLogic.php';
  $user_id = $_POST['user_id'];
  $current_user_id = $_POST['current_user_id'];
    if(UserLogic::check_follow($current_user_id,$user_id)){
      $action = '解除';
      $flash_type = 'error';
      $sql ="DELETE
              FROM relation
              WHERE :follow_id = follow_id AND :follower_id = follower_id";
    }else{
      $action = '登録';
      $flash_type = 'sucsess';
      $sql ="INSERT INTO relation (follow_id,follower_id)
              VALUES(:follow_id,:follower_id)";
    }
    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute(array(':follow_id' => $current_user_id , ':follower_id' => $user_id));
      // $return = array('action' => $action,
      // 'follow_count' => current(UserLogic::get_user_count('follow',$current_user_id)),
      // 'follower_count' => current(UserLogic::get_user_count('follower',$current_user_id)));
      echo UserLogic::get_user_count('follower', $current_user_id);
    }
    catch (\Exception $e) {
      exit("Can't insert ERROR!".$e -> getMessage());
    }
?>