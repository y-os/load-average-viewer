<?php
/*
	ロードアベレージのログを表示
	Copyright (c) Y.Oshima
*/
require('./setting.php');

$filename = LOG_FILEPATH;//ログファイル名
$filedata = array();//ログファイルのデータ。タブ区切りで保存されている。

if(file_exists($filename)){
	$filedata = file($filename, FILE_IGNORE_NEW_LINES);
}


$table_data = array();//テーブル表示
$jp_week = array('日','月','火','水','木','金','土');

//Chart.js グラフ用データ
$chart_labels = array();
$chart_data_1min = array();
$chart_data_5min = array();
$chart_data_15min = array();


foreach($filedata as $value){
	$values = explode("\t", $value);
	
	preg_match("/load averages?: ([\w\.]+), ([\w\.]+), ([\w\.]+)/", $values[2], $load_average);
	
	$chart_labels[] = date('d' . $jp_week[date('w', $values[0])] . 'H:i', $values[0]);
	$chart_data_1min[] = $load_average[1];
	$chart_data_5min[] = $load_average[2];
	$chart_data_15min[] = $load_average[3];
	
	preg_match("/up ([\w\s\.:]+),/", $values[2], $ptime);
	
	$table_data[] = '<tr><td>' . date('Y-m-d(' . $jp_week[date('w', $values[0])] . ')H:i:s', $values[0])  . '</td>'
		. '<td>' . $load_average[1] . '</td>'
		. '<td>' . $load_average[2] . '</td>'
		. '<td>' . $load_average[3] . '</td>'
		. '<td>' . $ptime[1] . '</td></tr>';
}

krsort($table_data);

$page_title = 'ロードアベレージ・ログ';
require('./page_header.php');
?>



<h2>ロードアベレージ・ログ</h2>
<h3>グラフ</h3>

<div>
<canvas id="ex_chart"></canvas>
</div>

<script>
window.addEventListener('load', function(){

var ctx = document.getElementById('ex_chart');

var data = {
	labels: [<?php echo '"' . implode('","', $chart_labels) . '"'; ?>],
	datasets: [{
		label: '直近1分',
		data: [<?php echo implode(',', $chart_data_1min); ?>],
		borderColor: 'rgba(255, 100, 100, 1)',
		fill: true,
		backgroundColor: 'rgba(255, 100, 100, 0.1)',
		borderWidth: 1
	},
	{
		label: '直近5分',
		data: [<?php echo implode(',', $chart_data_5min); ?>],
		borderColor: 'rgba(100, 255, 100, 1)',
		fill: true,
		backgroundColor: 'rgba(100, 255, 100, 0.1)',
		borderWidth: 1
	},
	{
		label: '直近15分',
		data: [<?php echo implode(',', $chart_data_15min); ?>],
		borderColor: 'rgba(100, 100, 255, 1)',
		fill: true,
		backgroundColor: 'rgba(100, 100, 255, 0.1)',
		borderWidth: 1
	}]
};

var options = {
	scales:{
		x:{
			display:true,
			title:{
				display:true,
				text:'日時'
			}
		},
		y:{
			display:true,
			min:0,
			title:{
				display:true,
				text:'ロードアベレージ'
			}
		}
	}
};

var ex_chart = new Chart(ctx, {
	type: 'line',
	data: data,
	options: options
});

}, false);
</script>





<h3>表</h3>
<table class="ex_table_log">
<tr>
<td rowspan="2">日時</td>
<td colspan="3">ロードアベレージ</td>
<td rowspan="2">稼働時間</td>
</tr>
<tr>
<td>直近1分</td>
<td>直近5分</td>
<td>直近15分</td>
</tr>
<?php echo implode('', $table_data); ?>
</table>





<?php
require('./page_footer.php');
