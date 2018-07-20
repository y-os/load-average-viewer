# Load Average Viewer
本プログラムはウェブサーバーの現在のロードアベレージを表示したり、CPUのスペックを表示するツールです。
cronを使用して定期的にロードアベレージを記録し、それをグラフと表で表示することもできます。

以下のレンタルサーバーで動作を確認済みです。
* エックスサーバー（X10）
* コアサーバー（CORE-A）
* さくらのレンタルサーバ（スタンダード）



## ファイル
### 主な構成
* index.php: メインページ。現在のロードアベレージやCPUのスペックを表示する。
* logview.php: cronにより記録したログをグラフと表で表示する。
* cron.php: 定期的にロードアベレージを記録するためのcron用プログラム。
* cron.sh: cronでシェルをたたく必要がある場合に使用する。
* page_header.php: ヘッダ
* page_footer.php: フッタ
* setting.php: 各種設定
* index.css: CSS
* log.cgi: cronで記録すると作成されるログファイル
* .htaccess: cron関係のファイルへのアクセスを拒否するために使用。
* Chart.min.js: グラフを作成するJavaScript（Chart.js）


### 設置場所
ファイルは他人に知られない場所に置くことをおすすめします。
念のためcronで始まるファイル名には外部からアクセスできないように.htaccessに記述しています。
cron関連のファイルの置き場所を変更したり、リネームしたり、Basic認証を導入したい場合などは自分で改良してください。



### 動作環境
* OS： Linux、FreeBSD
* 言語： PHP 7.x
* 文字コード： UTF-8

OSの種類（Linux、FreeBSD）により表示内容が異なります。
さくらのレンタルサーバなどFreeBSDを使っている場合、CPUは一部の情報のみ表示されます。



## cronの設定
cronは自分で設定してください。
レンタルサーバーの場合はコントロールパネルから設定できます。
エックスサーバーとさくらはコマンドにcron.phpを直接指定できますが、コアサーバーはcron.shを使用して実行する必要があります。
cron.shを使う場合は、その中身を自分の環境に合わせて編集してください。

cronは1時間おきに記録することを想定しています。
1時間おきの場合は、分は 0、時間は */1、それ以外(日、月、曜日)は * を指定します。

### コマンド例
#### エックスサーバー
```
cd /home/ユーザー名/ドメイン名/public_html/(中略)/cron.phpがあるディレクトリ名/ ; /usr/bin/php7.1 ./cron.php
```

#### コアサーバー
```
/virtual/ユーザー名/public_html/ドメイン名/(中略)/cron.sh >/dev/null 2>&1
```

cron.sh は以下のように自分の環境に合わせて書き換えます。

```
#!/bin/sh
/usr/local/bin/php /virtual/ユーザー名/public_html/ドメイン名/(中略)/cron.php
```

#### さくらのレンタルサーバ
```
cd /home/ユーザー名/www/(中略)/cron.phpがあるディレクトリ名/ ; /usr/local/bin/php ./cron.php 1> /dev/null
```



## 著作権
Copyright (c) Y.Oshima



## ライセンス
MIT License

詳しくはLICENSE.mdをご覧ください。
