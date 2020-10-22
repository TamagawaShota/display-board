<?php

/**
 * ユーティリティクラス
 *
 * @version 1.0
 * @author s108304
 */
class Util
{
    /**
     *  トークン文字列作成
     *
     */
	public static function CreateToken($length = 16)
    {
		$tokenByte = openssl_random_pseudo_bytes(16);
		$tokenStr = bin2hex($tokenByte);
		return $tokenStr;
	}

	
    /**
     *  新規パスワード文字列作成(未使用)
     *
     */
	public static function CreateNewPassword()
    {
		return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
	}
	
	/**
	 *  GCPで動いているか判定
	 *
	 */
	public static function IsGCP()
	{
		return array_key_exists("GAE_INSTANCE", $_SERVER);
	}
}

