<?php
  require_once "../classes/adminLogic.php";
  $shop = $_GET;

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
	  $shop = $_POST['shopId'];
	  delete('shop', $shop);
  }

?>

<head>
	<?php require 'head.php'; ?>
</head>

<body>
<h2>本当に退会しますか？</h2>
<form action="deleteShop.php" method="post">
	<input type="hidden" name="shopId" value="<?php echo $shop['id']; ?>">
	<input type="submit" name="delete" value="退会する">
</form>
  <input type="button" value="戻る" onClick="history.back()">
</body>