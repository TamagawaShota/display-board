<?php
// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

// アクセストークンを使いCurlHTTPClientをインスタンス化
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
// LINE Messaging APIがリクエストに付与した署名を取得
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// 署名が正当かチェック。正当であればリクエストをパースし配列へ
// 不正であれば例外の内容を出力
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}


// json取得
$json_string = file_get_contents('php://input');
$res_json = json_decode($json_string);
if(!empty($res_json)){
    // LINEのuserId
    $userId = $res_json->{'id'};
    // 受付番号
    $recNum = $res_json->{'no'};
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('もうすぐ呼ばれますので準備をお願い致します。' . "\r\n" . '受付番号:' . $recNum);
}
else{
    $userId = 'Udbe1177667bb097cc235b265e2df1139';
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('json読み込めませんでした。');
}

$response = $bot->pushMessage($userId, $textMessageBuilder);

?>