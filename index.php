<?php
/*
	HOME
	Copyright (c) Y.Oshima
*/
exec('hostname', $hn_out);//ホスト名
exec('uptime', $ut_out);//ロードアベレージ
exec('uname -s', $unames_out);//OSタイプ
exec('uname -a', $unamev_out);//OS情報


/*
	Linux は load average:、FreeBSD（さくらなど）は load averages:
*/
preg_match("/load averages?: ([\w\.]+), ([\w\.]+), ([\w\.]+)/", $ut_out[0], $load_average);
preg_match("/up ([\w\s\.:]+),/", $ut_out[0], $ptime);

exec('vmstat', $vmstat_out);//vmstat
exec('free', $free_out);//free
exec('top | grep Free', $top_out);//top


//CPU
$cpu_model_name = array();
$cpu_physical_id = array();
$cpu_cpu_cores = array();
$cpu_siblings = array();

$cpu_physical_id_count = '';
$cpu_siblings_threads = '';


if($unames_out[0] == 'FreeBSD'){
	//FreeBSD の場合
	exec('sysctl hw', $cpuinfo);
	//exec('sysctl kern.smp', $cpuinfo);
	//exec('cat /var/run/dmesg.boot', $cpuinfo);
	
	foreach($cpuinfo as $cpuinfo_value){
		$cpuinfo_values = explode(':', $cpuinfo_value);
		$cpuinfo_values[0] = trim($cpuinfo_values[0]);
		
		switch($cpuinfo_values[0]){
			case 'hw.model':
				$cpu_model_name[] = $cpuinfo_values[1];
				break;
			case 'hw.ncpu':
				$cpu_cpu_cores[] = $cpuinfo_values[1];
				break;
		}
	}
	
	$cpu_physical_id_count = '不明';
	$cpu_siblings_threads = '不明';
	
}else{
	//Linux の場合
	exec('cat /proc/cpuinfo', $cpuinfo);
	//exec('grep "physical id" /proc/cpuinfo | sort | uniq', $cpuinfo);
	//exec('grep "siblings" /proc/cpuinfo', $cpuinfo);
	
	foreach($cpuinfo as $cpuinfo_value){
		$cpuinfo_values = explode(':', $cpuinfo_value);
		$cpuinfo_values[0] = trim($cpuinfo_values[0]);
		
		switch($cpuinfo_values[0]){
			case 'model name':
				$cpu_model_name[] = $cpuinfo_values[1];
				break;
			case 'physical id':
				$cpu_physical_id[] = $cpuinfo_values[1];
				break;
			case 'cpu cores':
				$cpu_cpu_cores[] = $cpuinfo_values[1];
				break;
			case 'siblings':
				$cpu_siblings[] = $cpuinfo_values[1];
				break;
		}
	}
	
	$cpu_model_name = array_unique($cpu_model_name);
	$cpu_physical_id = array_unique($cpu_physical_id);
	$cpu_cpu_cores = array_unique($cpu_cpu_cores);
	$cpu_siblings = array_unique($cpu_siblings);
	
	$cpu_physical_id_count = count($cpu_physical_id) . '個';
	$cpu_siblings_threads = $cpu_siblings[0] . 'スレッド';
}



require('./setting.php');
$page_title = APP_NAME;
require('./page_header.php');
?>



<h2>サーバー情報</h2>
<table class="ex_table_index">
<tr><td>ホスト名</td><td><?php echo $hn_out[0]; ?></td></tr>
<tr><td>IPアドレス</td><td><?php echo gethostbyname($hn_out[0]); ?></td></tr>
<tr><td>IPアドレス(内部)</td><td><?php echo $_SERVER['SERVER_ADDR']; ?></td></tr>
<tr><td>ロードアベレージ</td><td><?php echo $load_average[1]; ?>（直近1分）<br /><?php echo $load_average[2]; ?>（直近5分）<br /><?php echo $load_average[3]; ?>（直近15分）</td></tr>
<tr><td>稼働時間</td><td><?php echo $ptime[1]; ?></td></tr>
<tr><td>OSタイプ</td><td><?php echo $unames_out[0]; ?></td></tr>
</table>



<h2>CPU</h2>
<table class="ex_table_index">
<tr><td>モデル</td><td><?php echo $cpu_model_name[0]; ?></td></tr>
<tr><td>搭載個数</td><td><?php echo $cpu_physical_id_count; ?> / 1台</td></tr>
<tr><td>コア数</td><td><?php echo $cpu_cpu_cores[0]; ?>コア / 1CPU</td></tr>
<tr><td>スレッド数</td><td><?php echo $cpu_siblings_threads; ?> / 1CPU</td></tr>
</table>



<h2>コマンド結果（plain）</h2>
<p><b>hostname</b><br><?php echo $hn_out[0]; ?></p>

<p><b>uptime</b><br><?php echo $ut_out[0]; ?></p>

<p><b>uname</b><br><?php echo $unamev_out[0]; ?></p>


<pre>
<?php
echo "<b>vmstat</b>\n";

if(!empty($vmstat_out)){
	
	foreach($vmstat_out as $vmstat_value){
		echo $vmstat_value . "\n";
	}
	
}else{
	echo "N/A\n";
}

echo "\n<b>free</b>\n";

if(!empty($free_out)){
	foreach($free_out as $free_value){
		echo $free_value . "\n";
	}
}else{
	echo "N/A\n";
}

echo "\n<b>top</b>\n";

if(!empty($top_out)){
	
	foreach($top_out as $top_value){
		echo $top_value . "\n";
	}
}else{
	echo "N/A\n\n";
}
?>
</pre>




<?php
require('./page_footer.php');
