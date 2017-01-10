<?php /* Smarty version 2.6.30, created on 2017-01-06 07:50:38
         compiled from delete_Smarty.tpl */ ?>
<!doctype html>
<html>
<head>
<title>削除画面</title>
</head>
<body>


<h2>削除画面</h2>
		<form id="deleteform" name = "deleteform" action="" method="POST">
			<fieldset>
				<legend>削除フォーム</legend>
				<div><font color="#ff0000"><?php echo $this->_tpl_vars['errors']; ?>
</font></div>
				<div>投稿IDとユーザーIDのパスワードを入力すると自分の投稿のみ削除できます。</div>
				<label for="id">投稿ID</label>
				<input type="text" id="id" name="id" placeholder="投稿IDを入力" value=""autocomplete="off">
				<br>
				<label for="password">パスワード</label>
				<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
				<br>
				<input type="submit" id="delete" name="delete" value="削除">
			</fieldset>
		</form>
		<form action="board_Smarty.php">
			<fieldset>
				<legend>掲示板へ戻る</legend>
				<input type="submit" value="掲示板へ">
			</fieldset>
		</form>
</body>
</html>