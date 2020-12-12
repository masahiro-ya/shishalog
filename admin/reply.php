<?php
  require_once '../classes/adminLogic.php';
  require_once '../function.php';
  $reply = $_GET['id'];

  if($reply == "noreply"){
  	$inquiry = inquiry($reply);
  }elseif($reply == "okreply"){
  	$inquiry = inquiry($reply);
  }
?>

<head>
	<?php require 'head.php'; ?>
</head>

<body>
	<?php require 'header.php'; ?>

	<div class="container">
		<table class="table">
			<?php if($reply == "noreply"): ?>
				<?php foreach ($inquiry as $key): ?>
					<tr>
						<th>お名前</th>
						<th>タイトル</th>
						<th>内容</th>
						<th>お問い合わせ日</th>
					</tr>
	        <tr>
						<th><?php echo h($key['name']) ?></th>
						<th><?php echo h($key['title']) ?></th>
						<th><?php echo h($key['content']) ?></th>
						<th><?php echo h($key['post_at']) ?></th>
						<th><a class="btn-primary" href="response.php?id=<?php echo $key['ID'] ?>">返信する</a></th>
					</tr>
				<?php endforeach; ?>
			<?php elseif($reply == "okreply"): ?>
				<?php foreach ($inquiry as $key): ?>
					<tr>
						<th>お名前</th>
						<th>タイトル</th>
						<th>内容</th>
						<th>返信内容</th>
						<th>お問い合わせ日時</th>
					</tr>
	        <tr>
						<th><?php echo h($key['name']) ?></th>
						<th><?php echo h($key['title']) ?></th>
						<th><?php echo h($key['content']) ?></th>
						<th><?php echo h($key['reply']) ?></th>
						<th><?php echo h($key['post_at']) ?></th>
						<th><a class="btn-primary" href="response.php?id=<?php echo $key['ID'] ?>">返信する</a></th>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
</body>