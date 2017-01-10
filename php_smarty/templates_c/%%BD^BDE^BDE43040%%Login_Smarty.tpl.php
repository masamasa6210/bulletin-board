<?php /* Smarty version 2.6.30, created on 2017-01-06 07:00:52
         compiled from Login_Smarty.tpl */ ?>
<!doctype html>
<html>
<head>
<title>ログイン画面</title>
</head>
<body>


<h1>ようこそ！掲示板へ！</h1>
		<form id="loginForm" name = "loginForm" action="" method="POST">
			<fieldset>
				<legend>ログインフォーム</legend>
				<div><font color="#ff0000"><?php echo $this->_tpl_vars['errors']; ?>
</font></div>
				<label for="userid">ユーザーID</label>
				<input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="" autocomplete="off">
				<br>
				<label for="password">パスワード</label>
				<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
				<br>
				<input type="submit" id="login" name="login" value="ログイン">
			</fieldset>
		</form>
		<br>
		<form action="SignUp_Smarty.php">
			<fieldset>
				<legend>新規登録フォーム</legend>
				<input type="submit" value="新規登録">
			</fieldset>
		</form>
</body>
</html>