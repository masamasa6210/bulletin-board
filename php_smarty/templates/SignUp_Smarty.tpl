<!doctype html>
<html>
<body>
<h2>新規登録画面</h2>
	<form id = "loginForm" name = "loginForm" action = "" method="post">
		<fieldset>
					<legend>新規登録フォーム</legend>
					<div><font color="#ff0000">{$errors}</font></div>
					<div><font color="#0000ff">{$signup}</font></div>
					<div><font color="#0000ff">ユーザー名は20文字以内、パスワードは英数字で4文字以上8文字以内で入力してください。</font></div>
					<label for="username">ユーザー名</label>
					<input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="" autocomplete="off">
					<br>
					<label for="password">パスワード</label>
					<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
					<br>
					<label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力" autocomplete="off">
					<br>
					<input type="submit" id="signUp" name="signUp" value="新規登録">
		</fieldset>
	</form>
	<form action="Login_Smarty.php">
			<fieldset>
				<legend>	ログインフォーム</legend>
				<input type="submit" value="ログイン画面へ">
			</fieldset>
		</form>
</body>
</html>