<!doctype html>
<html>
<head>
<title>編集画面</title>
</head>
<body>


<h2>編集画面</h2>
		<form id="deleteform" name = "deleteform" action="" method="POST">
			<fieldset>
				<legend>編集フォーム</legend>
				<div><font color="#ff0000">{$errors}</font></div>
				<div>投稿IDとメッセージとユーザーIDのパスワードを入力すると自分の投稿のみ編集できます。</div>
				<label for="id">投稿ID</label>
				<input type="text" id="id" name="id" placeholder="投稿IDを入力" value="" autocomplete="off">
				<br>
				<label for="contents">メッセージ</label>
				<input type="text" id="contents" name="contents" placeholder="メッセージを入力" value="" autocomplete="off">
				<br>
				<label for="password">パスワード</label>
				<input type="password" id="password" name="password" value="" placeholder="パスワードを入力" autocomplete="off">
				<br>
				<input type="submit" id="edit" name="edit" value="編集">
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