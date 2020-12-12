<?php
  require_once '../classes/adminLogic.php';
  // $inquiry = searchInquiry()
?>
<head>
	<?php require 'head.php'; ?>
</head>

<body>
	<?php require 'header.php'; ?>

	<div class="container">
		<a href="reply.php?id=noreply" class="btn btn-primary offset-5 col-2 mb-5">未返信</a>
		<a href="reply.php?id=okreply" class="btn btn-primary offset-5 col-2 mb-5">返信済み</a>
	</div>
	<?php require 'footer.php'; ?>
</body>