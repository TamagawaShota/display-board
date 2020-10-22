<?php
require_once('util.php');

/**
 * ロガークラス
 *
 * @version 1.0
 * @author s108304
 */
class Logger
{
    /**
     * 情報ログ書き込み
     *
     * $log ログ文字列
     *
     */
    public static function Info($log)
    {
        $contents = "【INFO】";
        $contents .= " ";
        $contents .= $log;

        Logger::Write(LOG_INFO, $contents);
    }

    /**
     * エラーログ書き込み
     *
     * $log ログ文字列
     *
     */
    public static function Error($log)
    {
        $contents = "【ERROR】";
        $contents .= " ";
        $contents .= $log;

        Logger::Write(LOG_ERR, $contents);
    }

    /**
     * 例外ログ書き込み
     *
     * $ex 例外 Excepitonクラス
     *
     */
    public static function Exception($ex)
    {
        $contents = "【EXCEPTION】";
        $contents .= "ファイル：";
        $contents .= $ex->getFile();
        $contents .= "行：";
        $contents .= $ex->getLine();
        $contents .= "コード：";
        $contents .= $ex->getCode();
        $contents .= "\r\n";
        $contents .= "内容：";
        $contents .= $ex->getMessage();

        Logger::Write(LOG_ERR, $contents);
    }

    /**
     * ログ書き込み
     *
     * $log ログ文字列
     *
     */
    private static function Write($type, $log)
    {
		//GCPではログファイルを参照できないため、Webサーバのログに残します。
		if(Util::IsGCP())
		{
			syslog($type, $log);
		//	error_log($log);		
			return;
		}
		//ログファイル名を設定します。
		$logFilePath = Logger::CreateLogFilePath();

		// 出力文字列を生成します。
		$contents = date("Y-m-d H:i:s");
		$contents .= " ";
		$contents .= "【IP】";
		$contents .= " ";
		$contents .= $_SERVER['REMOTE_ADDR'];
		$contents .= " ";
		$contents .= $log;
		$contents .= "\r\n";

		//ファイルをオープンします。
		$fileObj = @fopen($logFilePath, "a");

		// ファイルオープンに失敗したら終了です。
		if(!$fileObj)
		{
		    return;
		}

		//ロックします。
		flock($fileObj, LOCK_EX);

		//書き込み
		fwrite($fileObj, $contents);

		//ロックを解除します。
		flock($fileObj, LOCK_UN);

		//クローズします。
		fclose($fileObj);
		
	}

    /**
     * ログファイルパス作成
     *
     */
    private static function CreateLogFilePath(){
        
        $logFolderPath = "./Log";

		//フォルダチェック
		if(!is_dir($logFolderPath))
        {
			//ない場合は作成します。
            mkdir($logFolderPath);
		}

		//ファイル名を設定します。
		$logFileName = "pkonline_" . date("Ymd") . ".log";

		//ログファイルパスを設定します。
		$logFilePath = $logFolderPath . "/" . $logFileName;

		return $logFilePath;
	}
}
?>