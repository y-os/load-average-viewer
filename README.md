# Load Average Viewer
本プログラムはウェブサーバーのロードアベレージを表示するためのツールです。
cronを使用して定期的にロードアベレージを記録し、グラフと表で見ることもできます。
サーバーの負荷を監視したいときなどにご利用ください。

また、CPUやメモリーなどのハードウェア情報も表示できます。
ただし、それらを見るためのコマンドや情報の取得が許可されているサーバーに限ります。


## 動作確認レンタルサーバー
* エックスサーバー（スタンダード）
* コアサーバー（V1、V2）
* さくらのレンタルサーバ（スタンダード）
* ConoHa WING（ベーシック）



## ファイル
### 主な構成
* index.php: メインページ。現在のロードアベレージやCPUのスペックを表示する。
* logview.php: cronにより記録したログをグラフと表で表示する。
* cron.php: 定期的にロードアベレージを記録するためのcron用プログラム。
* cron.sh: cronでシェルをたたく必要がある場合に使用する。
* page_header.php: ヘッダ
* page_footer.php: フッタ
* setting.php: 各種設定
* app_info.php: アプリ情報
* index.css: CSS
* cron.log: cronで記録すると作成されるログファイル
* .htaccess: cron関係のファイルへのアクセスを拒否するために使用。
* Chart.min.js: グラフを作成するJavaScript（Chart.js）



### 設置場所
各ファイルは他人に知られない場所に置くことをおすすめします。
念のためcronで始まるファイル名には外部からアクセスできないように.htaccessに記述しています。
cron関連のファイルの置き場所を変更したり、リネームしたり、Basic認証の導入など、自分で適当に対応してください。



### 動作環境
* OS： Linux、FreeBSD
* 言語： PHP 8.x
* 文字コード： UTF-8

OSの種類（Linux、FreeBSD）により表示内容が異なります。
さくらのレンタルサーバでは、CPUなどハードウェア情報は一部のみ表示されます。



## cronの設定
cronは自分で設定してください。
たいていのレンタルサーバーではコントロールパネルから設定できます。
エックスサーバーとさくらはコマンドにcron.phpを直接指定できますが、コアサーバー（V1）はcron.shを使用して実行する必要があります。
cron.shを使う場合、その中身を自分の環境に合わせて編集してください。

cronは1時間おきに記録することを想定しています。
1時間おきの場合は、分は 0、それ以外(時間、日、月、曜日)は * を指定します。

### コマンド例
#### エックスサーバー
```
cd /home/ユーザー名/ドメイン名/public_html/(中略)/cron.phpがあるディレクトリ名/ ; /usr/bin/php8.2 ./cron.php
```

#### コアサーバー
V1プランの場合

```
/virtual/ユーザー名/public_html/ドメイン名/(中略)/cron.sh >/dev/null 2>&1
```

末尾の 2>&1 はcronの出力をpostmaster（メール）へ送りたくない場合の指定。
cron.sh は以下のように自分の環境に合わせて書き換えます。

```
#!/bin/sh
/usr/local/bin/php /virtual/ユーザー名/public_html/ドメイン名/(中略)/cron.php
```

V2プランは以下のように直接PHPを実行できました。

```
cd /home/ユーザー名/domains/ドメイン名/(中略)/cron.phpがあるディレクトリ名/ ; /usr/local/bin/php ./cron.php >/dev/null 2>&1
```


#### さくらのレンタルサーバ
```
cd /home/ユーザー名/www/(中略)/cron.phpがあるディレクトリ名/ ; /usr/local/bin/php ./cron.php 1> /dev/null
```

末尾の 1> /dev/null はcronの出力をpostmaster（メール）へ送りたくない場合の指定。



#### ConoHa WING
```
cd /home/ユーザー固有番号/public_html/ドメイン名/(中略)/cron.phpがあるディレクトリ名/ ; /usr/bin/php ./cron.php > /dev/null
```

ユーザー固有番号はConoHaのコントロールパネルの「FTP」→「接続許可ディレクトリ」に記載されています。





### ログの保存件数
初期値は200件です。
setting.php 内にある定数 LOG_LINES で保存件数を変更できます。



## 注意事項
本プログラムを利用して発生したいかなる損害に対して作者は一切の責任を負いません。



## 著作権
Copyright (c) Y.Oshima



## ライセンス
MIT License

詳しくはLICENSE.mdをご覧ください。
