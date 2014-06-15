<?php
include "default.php";
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $_GET['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$data = curl_exec($ch);
curl_close($ch);
$handle = fopen("date_range.json", "w");
fwrite($handle, $data);
fclose($handle);
include "header.php";
?>
<h1>성공</h1>
<?php include "footer.php" ?>