<?php
  require_once '../classes/adminLogic.php';
  require_once '../function.php';
  $inquiry = getinquiry($_GET['id']);
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $err = validation($_POST);
  }
?>
<head>
  <?php require 'head.php'; ?>
</head>

<body>
	<?php require 'header.php'; ?>

	<div class="container">
		<h3 class="my-5" style="text-align: center;">お問い合わせ</h3>
		<table class="table">
				<tr>
					<th>氏名</th>
					<th><?php echo h($inquiry['name']); ?></th>
				</tr>
        <tr>
					<th>メールアドレス</th>
					<th><?php echo h($inquiry['address']); ?></th>
				</tr>
				<tr>
					<th>タイトル</th>
					<th><?php echo h($inquiry['name']); ?></th>
				</tr>
				<tr>
					<th>お問い合わせ内容</th>
					<th><?php echo h($inquiry['content']); ?></th>
				</tr>
		</table>
		<form action="response.php?id=<?php echo $inquiry['ID'] ?>" method="post">
      <h4 style="text-align: center;">返信フォーム</h4>
      <textarea name="reply" cols="80" rows="8" class="row offset-2 col-8"></textarea>
      <input type="hidden" value="<?php echo h($inquiry['ID']); ?>" name="id">
      <input type="hidden" value="<?php echo h($inquiry['address']); ?>" name="address">
      <input type="hidden" value="<?php echo h($inquiry['content']); ?>" name="content">
      <input type="hidden" value="<?php echo h($inquiry['name']); ?>" name="name">
			<input type="submit" class="offset-5 col-2 my-5 btn btn-primary" name="submit" value="送信する" id="submitbtn">
			<?php if(!empty($err)): ?>
			  <?php echo $err ?>
			<?php endif ?>
		</form>
  </div>
  <?php require 'footer.php'; ?>
</body>