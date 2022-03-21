<?php
/*
	ヘッダー
	Copyright (c) Y.Oshima
*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo $page_title;?></title>
<link rel="stylesheet" href="./index.css">

<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
<meta name="format-detection" content="telephone=no">
<meta name="robots" content="noindex,nofollow">

<script async src="./chart.js/chart.min.js"></script>

</head>
<body>



<!-- ヘッダー -->
<header id="page_header">
<?php echo APP_NAME;?>
</header>



<!-- メニュー -->
<nav class="page_menu">
<ul>
<li><a href="./">HOME</a></li>
<li><a href="./logview.php">ログ表示</a></li>
</ul>
</nav>



<!-- メイン -->
<div id="page_main">
