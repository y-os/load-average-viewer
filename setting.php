<?php
/*
	設定
	Copyright (c) Y.Oshima
*/

error_reporting(0);//エラー表示

define('APP_NAME', 'Load Average Viewer');//名称
define('APP_VERSION', '2022.04.14');//バージョン

define('LOG_FILEPATH', './cron.log');//ログファイルのパス
define('LOG_LINES', 200);//ログの保存件数（行数）
define('CRON_ADDR', '');//cronの実行制限。'on' にすると同じサーバーからのみ実行。
