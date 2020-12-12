<?php
  require_once '../db_connect.php';

  class shopLogic {

  	public static function shopdetail($id){
  		$id = $_GET['id'];
  		$stmt = connect()->prepare('SELECT * FROM shop WHERE shopId = :id');
  		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
  		$stmt->execute();
  		$result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
  	}

    function isGood($userId, $shopId){
      // try{
      //   $sql = "SELECT *
      //           FROM favorite
      //           WHERE userId = :userId AND shopId = :shopId";
      //   $stmt = connect()->prepare($sql);
      //   $stmt->execute(array(':userId' => $userId ,
      //                        ':shopId' => $shopId));
      //   $favorite = $stmt->fetch();
      //   var_dump($favorite);
      //   return $favorite;
      // }catch (Exception $e) {
      //   error_log('エラー発生:' . $e->getMessage());
      //   echo json_encode("error");
      // }

        try {
          $sql = 'SELECT * FROM favorite WHERE userId = :userId AND shopId = :shopId';
          $data = array(':userId' => $userId, ':shopId' => $shopId);
          // クエリ実行
          $stmt = connect()->prepare($sql);
          $stmt->execute($data);

          if($stmt->rowCount()){
            return true;
          }else{
            return false;
          }

        } catch (Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
        }
    }

    function getGood($p_id){
      try {
        $sql = 'SELECT * FROM favorite AS f LEFT JOIN user AS u ON f.userId = u.userId WHERE f.shopId = :p_id AND u.deleteFlag = 0';
        $stmt = connect()->prepare($sql);
        // クエリ実行
        $stmt->execute(array(':p_id' => $p_id));

        if($stmt){
          return $stmt->fetchAll();
        }else{
          return false;
        }
      } catch (Exception $e) {
        error_log('エラー発生：'.$e->getMessage());
      }
    }

    function getPostData($p_id){
      try{
        $sql = 'SELECT * FROM shop WHERE shopId = :p_id';
        $stmt = connect()->prepare($sql);
        // クエリ実行
        $stmt->execute(array(':p_id' => $p_id));

        if($stmt){
          return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
          return false;
        }
      }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
    }

    function getComment($p_id){
      try{
        $sql = 'SELECT * FROM review WHERE shopId = :p_id';
        $stmt = connect()->prepare($sql);
        // クエリ実行
        $stmt->execute(array(':p_id' => $p_id));

          if($stmt){
            return $stmt->fetchAll();
          }else{
            return false;
          }
      }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
    }

    function starAvg($id){
      try{
        $sql = 'SELECT AVG(star) FROM review WHERE shopId = :id';
        $stmt = connect()->prepare($sql);
        $stmt->execute(array(':id' => $id));
          if($stmt){
            return $stmt->fetchColumn();
          }else{
            return false;
          }
      }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
    }

    function get_gps_from_address($address){
        $res = array();
        $req = 'https://maps.google.com/maps/api/geocode/xml';
        $req .= '?address='.urlencode($address);
        $req .= '&sensor=false&key='.$_ENV["DB_MAP"];
        $xml = simplexml_load_file($req) or die('XML parsing error');
        if ($xml->status == 'OK') {
            $location = $xml->result->geometry->location;
            $res['lat'] = (string)$location->lat[0];
            $res['lng'] = (string)$location->lng[0];
        }
        return $res;
    }

    function favorite(){
      try{
        $sql = 'SELECT s.*, COUNT(s.shopId) FROM shop AS s LEFT JOIN favorite AS f ON s.shopId = f.shopId LEFT JOIN user AS u ON f.userId = u.userId WHERE s.shopId =f.shopId AND u.deleteFlag = 0 AND s.deleteFlag = 0 GROUP BY s.shopId ORDER BY COUNT(f.shopId) DESC LIMIT 5';
        $stmt = connect()->prepare($sql);
        // クエリ実行
        $stmt->execute();

          if($stmt){
            return $stmt->fetchAll();
          }else{
            return false;
          }
      }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
    }

    function star(){
      try{
        $sql = 'SELECT s.*, AVG(r.star) FROM shop AS s LEFT JOIN review AS r ON s.shopId = r.shopId LEFT JOIN user AS u ON r.userId = u.userId WHERE s.shopId = r.shopId AND u.deleteFlag = 0 AND s.deleteFlag = 0 GROUP BY s.shopId ORDER BY AVG(r.star) DESC LIMIT 5';
        $stmt = connect()->prepare($sql);
        // クエリ実行
        $stmt->execute();

          if($stmt){
            return $stmt->fetchAll();
          }else{
            return false;
          }
      }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
      }
    }
  }
?>