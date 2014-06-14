<?php
include "default.php";
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
        try{
            $accounts = $service->management_accounts->listManagementAccounts();
            $account_items = $accounts->getItems();
            foreach ($account_items as $account_item) { ?>
                <li>
                    <?php echo $account_item->name?>
                    <ul>
                        <?php
                        $properties = $service->management_webproperties->listManagementWebproperties($account_item->id);
                        $property_items = $properties->getItems();
                        foreach ($property_items as $property_item) { ?>
                            <li>
                                <?php echo $property_item->name ?>
                                <ul>
                                    <?php
                                    $profiles = $service->management_profiles->listManagementProfiles($property_item->accountId, $property_item->id);
                                    $profile_items = $profiles->getItems() ? $profiles->getItems() : array();
                                    foreach ($profile_items as $profile_item) { ?>
                                        <li>
                                            <a href=""><?php echo $profile_item->name ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        <?php }catch (Google_Auth_Exception $e){ ?>
            <li><?php echo $e->getMessage() ?></li>
        <?php } ?>
    </ul>
</body>
</html>