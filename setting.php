<?php
/*
	設定
	Copyright (c) Y.Oshima
*/
define('LOG_FILEPATH', './cron.log');//ログファイルのパス
define('LOG_LINES', 200);//ログの保存件数（行数）
define('CRON_ADDR', '');//cronの実行制限。'on' にすると同じサーバーからのみ実行。
