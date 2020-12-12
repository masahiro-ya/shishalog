<?php
  require_once("../classes/UserLogic.php");
  session_start();
  $post = $_SESSION;
  // $post = create($_SESSION['form']);
  UserLogic::inquiry($post);

?>

<!DOCTYPE html>
<html>
<head>
	<?php require("head.php"); ?>

</head>
<body>
	<?php require("header.php"); ?>
	<div id="wrap">
      <h1 style="text-align: center;">お問い合わせありがとうございました！</h1>
      <p style="text-align: center;"><a href="home.php" class="mr-3 btn btn-light">HOME</a></p>
	</div>
	<?php require("footer.php"); ?>

</body>
</html>