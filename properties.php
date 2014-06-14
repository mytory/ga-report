<?php
include "default.php";
$properties = $service->management_webproperties->listManagementWebproperties($_GET['account_id']);
$property_item = $properties->getItems();
?><!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>구글 아날리틱스 신문 통계</title>
</head>
<body>
<h1>구글 아날리틱스 신문 통계</h1>
<ul>
    <?php
    foreach ($property_item as $item) { ?>
        <li>
            <pre><?php print_r($item)?></pre>
            <a href="profiles.php?account_id=<?php echo $item->accountId ?>&property_id=<?php echo $item->id ?>"><?php echo $item->name?></a>
        </li>
    <?php } ?>
</ul>
</body>
</html>