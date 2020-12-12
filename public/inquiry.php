<?php
  require_once '../function.php';
  require_once '../classes/validation.php';
  $inquiry = validation($_POST);
?>

<!DOCTYPE html>
<html>
<head>
	<?php require("head.php"); ?>
</head>
<body>
	<?php require("header.php"); ?>
			<div class="container">
				<?php foreach ((array)$inquiry as $key) {
				  if($key){
				  	echo '<div style="color:red;">';
				  	echo implode('<br>', $key);
				  	echo '</div>';
				  }
				}
				?>
				<form action="inquiry.php" method="post">
					<h3 style="text-align: center;">お問い合わせ</h3>
					<dl class="mt-5">
						<dt class="offset-3 mb-3">氏名</dt>
						<dd><input type="text" class="offset-3 col-6" name="name" id="name" value="<?php echo h($post['name']); ?>"><br>
						<dt class="offset-3 mb-3">メールアドレス</dt>
						<dd><input type="email" class="offset-3 col-6" name="mail" id="mail" value="<?php echo h($post['mail']); ?>"><br>
						<dt class="offset-3 mb-3">タイトル</dt>
						<dd><input type="text" class="offset-3 col-6" name="title" id="name" value="<?php echo h($post['name']); ?>"><br>
					</dl>
					<p class="offset-3 mb-3">お問い合わせ内容</p>
					<textarea name="content" class="offset-3 col-6" rows="8" id="content"><?php echo h($post['content']); ?></textarea>
					<input type="submit" class="offset-5 col-2 my-5 btn btn-primary" name="submit" value="確認画面へ" id="submitbtn">
				</form>
	    </div>
	<?php require("footer.php"); ?>

</body>
</html>









