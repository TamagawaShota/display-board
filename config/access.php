<?php
    /**
     * 病院クラス
     */
    class Byoin{
        // 病院コード
        public static $byoinCode = '1001';

        /**
         * ファイルパス取得処理
         */
        public static function GetByoinFilePath() {
            $path = self::$byoinCode . '.php';
            return $path;
        }

        /**
         * お知らせ情報取得処理
         */
        public static function GetNewsMessage() {
            require(self::GetByoinFilePath());
            $result = '';
            foreach($newsMessage as $i => $value){
                if($i == 0) {
                    $result = $newsMessage[$i];
                    continue;
                }
                $result .= "\r\n" . $newsMessage[$i];
            }
            return $result;
        }

        /**
         * 連絡先情報取得処理
         */
        public static function GetContactMessage() {
            require(self::GetByoinFilePath());
            $result = '';
            foreach($contactMessage as $i => $value){
                if($i == 0) {
                    $result = $contactMessage[$i];
                    continue;
                }
                $result .= "\r\n" . $contactMessage[$i];
            }
            return $result;
        }

        /**
         * 施設コード取得処理
         */
        public static function GetFacilityCode() {
            require(self::GetByoinFilePath());
            return $facilityCode;
        }

        /**
         * ベースURL取得処理
         */
        public static function GetBaseUrl() {
            require(self::GetByoinFilePath());
            return $webBaseUrl;
        }
    }

    /**
     * LINE情報クラス
     */
    class LINEInfo{
        /**
         * LINEアクセストークン取得処理
         */
        public static function GetAccessToken() {
            require(Byoin::GetByoinFilePath());
            return $channelAccessToken;
        }

        /**
         * LINEチャネルシークレット取得処理
         */
        public static function GetChannelSecret() {
            require(Byoin::GetByoinFilePath());
            return $channelSecret;
        }
    }

    /**
     * メッセージクラス
     */
    class Message{
        // 非対応メッセージ
        public static $notReceptNumMessage = '受付番号の値が正しくありません。'
                                    . "\r\n" . '４桁以内の数値にて入力をお願いします。';
        // サーバ非応答メッセージ
        public static $notResponseMessage = 'サーバが応答しておりません。';
    }
?>