<head>
	<meta charset="utf-8">
</head>
<body>
	<form action="test.php" method="post">
		<input type="text" name="data" value="" placeholder="Find what...?">
		<label>Download ? <input type="checkbox" name="download" disabled="disabled"></label>
		<input type="submit" name="search">
	</form>
</body>
<?php
//http://japanparts.it/ data grabber by Uladzislau Murashka (https://linkedin.com/in/sm0k3)
require_once 'simple_html_dom.php';
$data = trim($_POST['data']);

if(!empty($data)) {
$ch = curl_init();
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_URL, "http://japanparts.it/item.jsp?code=".$data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_output = curl_exec($ch);
curl_close($ch);

$data_to_html = str_get_html($curl_output);

$length = array();
$length_num = array();
$id = htmlspecialchars($data);

foreach($data_to_html->find('tr') as $item) {
	if(preg_match('/length/', $item, $length)) {
		$l = $length[0];
	}
	if(preg_match('/length.+?\d{1,2}\.\d{1,2}/', $item, $length_num)) {
		$ln = explode(":", $length_num[0]);
	}
	if(preg_match('/width/', $item, $width)) {
		$w = $width[0];
	}
	if(preg_match('/width.+?\d{1,2}\.\d{1,2}/', $item, $width_num)) {
		$wn = explode(":", $width_num[0]);
	}
	if(preg_match('/height.+?\d{1,2}\.\d{1,2}/', $item, $height_num)) {
		$hn = explode(":", $height_num[0]);
	}
	if(preg_match('/weight.+?\d{1,5}\.\d{1,5}/', $item, $weight_num)) {
		$wen = explode(":", $weight_num[0]);
	}
}
?>
<table border="2">
	<tr><th>Ref. Num.</th><th>Length</th><th>Width</th><th>Heigth</th><th>Weight</th></tr>
	<tr><?php echo "<td>".$id."</td><td>".strip_tags($ln[1])."</td><td>".strip_tags($wn[1])."</td><td>".strip_tags($hn[1])."</td><td>".strip_tags($wen[1])."</td>";?></tr>
</table>
<?php
} else {
	echo "No data entered";
}
?>
</body>
