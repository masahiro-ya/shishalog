<?php
  session_start();
  require_once('../classes/UserLogic.php');
  header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <?php require '../public/head.php'; ?>
   <script type="text/javascript">
      /*
      * 登録前チェック
      */
      $(function(){
        $('input:submit').click(function(){
          if(!conrimMessage()){
            return false;
          }
        });
      });
      function conrimMessage() {
        var id = document.getElementById("id").value;
       //必須チェック
       if(id == "") {
          alert("必須項目が入力されていません。");
          return false;
       }else if(!id.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
          alert("正しいメールアドレスを入力してください。");
          return false;
      }
        return true;
      }
   </script>
</head>
  <body>
  <h2 class="mt-3" style="text-align: center; color: #fff;">SHISHALOG</h2>
    <img class="mb-4 col-2 offset-5 img-rounded" src="../img/logo.png" alt="" width="150" height="150">
    <div class="container col-md-6 offset-md-3 col-sm-10 offset-sm-1 my-5 py-5 rounded">
      <h3 style="text-align: center;">パスワード再発行</h2>
        <form action="resetmail.php" method="post">
        <input type="email" id="id" class="form-control row mb-5 col-md-6 offset-md-3 col-sm-10 offset-sm-1" name="email" placeholder="メールアドレス">
        <input type="submit" class="btn btn-primary row col-4 offset-4" value="仮パスワードを受け取る">
        <input type="button" onclick="window.history.back();" value="戻る" class="btn btn-primary row col-4 offset-4 mt-5">
      </form>
    </div>
</body>
</html>