<?php
  session_start();
  require_once '../db_connect.php';
  require_once 'userLogic.php';
  require_once 'shopLogic.php';

  if(isset($_POST)){
    $shopId = $_POST['shopId'];
    $userId = $_POST['userId'];
    $title = $_POST['title'];
    $star = $_POST['star'];
    $content = $_POST['content'];

      $sql ="INSERT INTO review (userId, shopId, title, body, star)
              VALUES(:userId, :shopId, :title, :content, :star)";
      $data = array(':shopId' => $shopId, ':userId' => $userId, ':title' => $title, ':content' => $content, ':star' => $star);

    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute($data);
      $starAvg = ShopLogic::starAvg($shopId);
      echo round($starAvg, 2);
    }
    catch (\Exception $e) {
      exit("Can't insert ERROR!".$e -> getMessage());
    }
  }
?>