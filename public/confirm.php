<?php
  session_start();
	require_once ("../function.php");
	require_once ("../classes/UserLogic.php");
	$post = $_SESSION;
?>
<!DOCTYPE html>
<html>
<head>
	<?php require("head.php"); ?>

</head>
<body>
	<?php require("header.php"); ?>
	<div class="container">
		<form action="complete.php" method="post">
			<table style="width: 100%">
				<h1 style="text-align: center;" class="my-5">これで送信してもよろしいですか？</h1>
					<tr>
						<th><h3>名前：</h3></th>
						<td><h3><?php echo h($post['name'], ENT_QUOTES, 'UTF-8'); ?></h3></td>
						<input type="hidden" name="name"></h3>
					</tr>
					<tr>
						<th><h3>メールアドレス：</h3></th>
						<td><h3><?php echo h($post['mail'], ENT_QUOTES, 'UTF-8'); ?></h3></td>
						<input type="hidden" name="mail">
					</tr>
					<tr>
						<th><h3>タイトル：</h3></th>
						<td><h3><?php echo h($post['title'], ENT_QUOTES, 'UTF-8'); ?></h3></td>
						<input type="hidden" name="mail"></h3>
					</tr>
					<tr>
						<th><h3>内容：</h3></th>
						<td><h3><?php echo nl2br(h($post['content'], ENT_QUOTES, 'UTF-8')); ?></h3></td>
						<input type="hidden" name="content">
					</tr>
			</table>
			  <div class="row justify-content-center">
			    <input type="button" name="back" value="戻る" onclick="history.back(-1)" class="mr-5 btn btn-primary">
			    <input type="submit" name="submit" value="送信" class="btn btn-primary">
			  </div>
	  </form>
	</div>
	<?php
	  require("footer.php");
	?>

</body>
</html>



