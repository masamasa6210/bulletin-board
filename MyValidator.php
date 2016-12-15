<?php
require_once 'C:\xampp\htdocs\php_data\DbManager.php';

class MyValidator {
	public $_errors;

	public function __construct() {
		$_errors = array();
	}

	public function requiredCheck($value, $name) {
		if(trim($value) === ''){
			echo $this->_errors[] = "{$name}は必須入力です。";
			echo '<br>';
	        echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
			exit;
		}
	}

	public function lengthCheck($value, $name, $len) {
		if(trim($value) !== ''){
			if(mb_strlen($value) > $len){
				echo $this->_errors[] = "{$name}は{$len}文字以内で入力してください。";
				echo '<br>';
	            echo '<a href="#" onclick="history.back(); return false;">前の画面に戻る</a>';
				exit;
			}
		}
	}
}

?>