<?php
//共通変数・関数ファイルを読込み
session_start();
require('../db_connect.php');
require_once 'userLogic.php';
require_once 'shopLogic.php';

// postがある場合
if(isset($_POST['postId'])){
    $p_id = $_POST['postId'];
    $login_user = $_SESSION['login_user'];

    try{
        //DB接続
        // goodテーブルから投稿IDとユーザーIDが一致したレコードを取得するSQL文
        $sql = 'SELECT * FROM favorite WHERE shopId = :p_id AND userId = :u_id';
        $data = array(':u_id' => $login_user['userId'], ':p_id' => $p_id);
        // // クエリ実行
        // $stmt = queryPost($dbh, $sql, $data);
        // $resultCount = $stmt->rowCount();

        $stmt = connect()->prepare($sql);
        $stmt->execute($data);
        $resultCount = $stmt->rowCount();
        // レコードが1件でもある場合
        if(!empty($resultCount)){
            // レコードを削除する
            $sql = "DELETE FROM favorite WHERE userId = :u_id AND shopId = :p_id";
            $data = array(':u_id' => $login_user['userId'], ':p_id' => $p_id);
            // クエリ実行
            $stmt = connect()->prepare($sql);
            $stmt->execute($data);
            echo count(shopLogic::getGood($p_id));
        }else{
            // レコードを挿入する
            $sql = "INSERT INTO favorite (userId, shopId) VALUES (:u_id, :p_id)";
            $data = array(':u_id' => $login_user['userId'], ':p_id' => $p_id);
            // クエリ実行
            $stmt = connect()->prepare($sql);
            $stmt->execute($data);
            echo count(shopLogic::getGood($p_id));
        }
    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
        echo json_encode("error");
    }
}

