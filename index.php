<?php
include "default.php";
$accounts = $service->management_accounts->listManagementAccounts();
$account_items = $accounts->getItems();
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
    foreach ($account_items as $item) { ?>
        <li>
            <a href="properties.php?account_id=<?php echo $item->id ?>"><?php echo $item->name?></a>
        </li>
    <?php } ?>
    </ul>
</body>
</html>