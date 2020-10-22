<?php
// 施設コード
$facilityCode = '0000000001';
// WebAPI接続先
$webBaseUrl = 'https://www.pk-line.com/';
/*
$url：jsonを飛ばす宛先のURL
$post：送信するパラメータ(エンコード済み)
$options：cURLの個別設定(無くてもよい)
*/
function curl_post($url, $post, array $options = array())
{
    // デフォルト設定
    $defaults = array(
        CURLOPT_POST => 1,              // POST
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),      //HTTPヘッダーフィールドの設定
        CURLOPT_URL => $url,            // URL
        CURLOPT_FRESH_CONNECT => 1,     // キャッシュクリア
        CURLOPT_RETURNTRANSFER => 1,    // 返り値を文字列で返す(通常はデータを出力)
        CURLOPT_FORBID_REUSE => 1,      // 処理が終了した際に明示的に接続を切断。再利用しない。
        CURLOPT_TIMEOUT => 4,           // curl関数の実行にかける時間の最大値
        CURLOPT_POSTFIELDS => $post    // 送信するデータ
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
/*
$url：jsonを飛ばす宛先のURL
$get：送信するパラメータ(エンコード済み)
$options：cURLの個別設定(無くてもよい)
*/
function curl_get($url, $get, array $options = array())
{
    // デフォルト設定
    $defaults = array(
        CURLOPT_CUSTOMREQUEST => 'GET', // GET
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),      //HTTPヘッダーフィールドの設定
        CURLOPT_URL => $url,            // URL
        CURLOPT_FRESH_CONNECT => 1,     // キャッシュクリア
        CURLOPT_RETURNTRANSFER => 1,    // 返り値を文字列で返す(通常はデータを出力)
        CURLOPT_FORBID_REUSE => 1,      // 処理が終了した際に明示的に接続を切断。再利用しない。
        CURLOPT_TIMEOUT => 4,           // curl関数の実行にかける時間の最大値
        CURLOPT_POSTFIELDS => $get      // 送信するデータ
    );
   
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
?>