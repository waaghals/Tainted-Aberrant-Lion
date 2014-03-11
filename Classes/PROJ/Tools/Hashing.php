<?php

namespace PROJ\Tools;

class Hashing {
	function createHash($password){
		$bytes = openssl_random_pseudo_bytes(64, $cstrong);
		$salt = bin2hex($bytes);
		if($cstrong){
			return hash('sha512', $password . $salt) . ";" . $salt;
		} else {
			return null;
		}
		return $salt;
	}

	function slowEquals($a, $b){
		$diff = strlen($a) ^ strlen($b);
		for($i = 0; $i < strlen($a) && $i < strlen($b); $i++){
			$diff |= ord($a[$i]) ^ ord($b[$i]);
		}
		return $diff === 0;
	}
}
?>