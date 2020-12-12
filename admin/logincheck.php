<?php
  session_start();
  require_once '../classes/adminLogic.php';
  require_once '../function.php';
  //ログインしているか判定し、していなかったら新規登録画面へ遷移
  $result = checkLogin();
  if(!$result){
  	$_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
  	header('Location: signup.php');
  	return;
  }
  $login_user = $_SESSION['login_user'];
?>