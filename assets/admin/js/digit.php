<?php
	$numeric_string = "hellow akhilesh";
	$datas = strlen($numeric_string);   // true

	//echo $datas;

$vars = '123456';
$kela = sprintf("%'.06d\n", $vars);
echo $kela;



//$list =  date('d F Y', strtotime($all_holiday_row->holiday_date));

//echo $current_date =  date('d-m-Y');

$date = '01/01/2009';
//echo $days = date('D', strtotime($date));

$timestamp = strtotime('18/10/2009');

$day = date('D', $timestamp);
//echo ($day);
$day = date('l', $timestamp);
//echo ($day);


?>

