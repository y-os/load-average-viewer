<?php
/*
	cronでロードアベレージを記録する
	Copyright (c) Y.Oshima
*/
require('./setting.php');


//同じサーバーからのみ実行できる制限
if(CRON_ADDR === 'on' && $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']){
	exit;
}


exec('hostname', $hn_out, $hn_return);//ホスト名
exec('uptime', $ut_out, $ut_return);//ロードアベレージ

$loglines = LOG_LINES;//ログ保存件数
$filename = LOG_FILEPATH;//ログファイル名
$filedata = array();//ログファイルのデータ。タブ区切りで保存されている。

//保存するデータ（タイムスタンプ, ホスト名, ロードアベレージ）
$input = array(time(), $hn_out[0], $ut_out[0]);


if(file_exists($filename)){
	$filedata = file($filename, FILE_IGNORE_NEW_LINES);
}


array_push($filedata, implode("\t", $input));

if(count($filedata) > $loglines){
	array_shift($filedata);
}


//echo '<pre>';
//print_r($filedata);
//echo '</pre>';


//保存
file_put_contents($filename, implode("\n", $filedata));
