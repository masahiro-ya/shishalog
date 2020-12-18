<?php
  require_once '../db_connect.php';

  class search{
  	public function searchparams($conditions, $select, $userId){
  		// 入力された検索条件からSQL文を生成
  		if($select === '店舗'){
		  	try{
			  		if(!empty($conditions)){
			  			$sql = "SELECT * FROM shop WHERE CONCAT(shopName, address) LIKE BINARY '%".$conditions."%' AND deleteFlag = 0";
			  		} else{
			  			$sql = "SELECT * FROM shop WHERE deleteFlag = 0";
			  		}

			  		$stmt = connect()->query($sql);
			  		$stmt->execute();
			  		return $stmt->fetchAll();
		    }catch(\Exception $e){
		    	error_log('エラー発生:' . $e->getMessage());
		      set_flash('error',ERR_MSG1);
		    }
	    }
  		if($select === 'ユーザー'){
		  	try{
		  		  if(isset($userId)){
				  		if(!empty($conditions)){
				  			$sql = "SELECT * FROM user WHERE CONCAT(name) LIKE BINARY '%".$conditions."%' AND deleteFlag = 0 AND userId != $userId";
				  		} else{
				  			$sql = "SELECT * FROM user WHERE deleteFlag = 0 AND userId != $userId";
				  		}
				  	}elseif(is_null($userId)){
				  		if(!empty($conditions)){
				  			$sql = "SELECT * FROM user WHERE CONCAT(name) LIKE BINARY '%".$conditions."%' AND deleteFlag = 0";
				  		} else{
				  			$sql = "SELECT * FROM user WHERE deleteFlag = 0";
				  		}
				  	}
			  		$stmt = connect()->query($sql);
			  		$stmt->execute();
			  		return $stmt->fetchAll();
		    }catch(\Exception $e){
		    	error_log('エラー発生:' . $e->getMessage());
		      set_flash('error',ERR_MSG1);
		    }
	    }
    }
  }

?>
