<?php include "default.php" ?>
<?php include "header.php" ?>
    <h1>구글 아날리틱스 신문 통계</h1>
    <ul>
        <?php
        try{
            $accounts = $analytics->management_accounts->listManagementAccounts();
            $account_items = $accounts->getItems();
            if( ! empty($account_items)){
                foreach ($account_items as $account_item) { ?>
                    <li>
                        <?php echo $account_item->name?>
                        <ul>
                            <?php
                            $properties = $analytics->management_webproperties->listManagementWebproperties($account_item->id);
                            $property_items = $properties->getItems();
                            if(! empty($property_items)){
                                foreach ($property_items as $property_item) { ?>
                                    <li>
                                        <?php echo $property_item->name ?>
                                        <ul>
                                            <?php
                                            $profiles = $analytics->management_profiles->listManagementProfiles($property_item->accountId, $property_item->id);
                                            $profile_items = $profiles->getItems();
                                            if( ! empty($profile_items)){
                                                foreach ($profile_items as $profile_item) { ?>
                                                    <li>
                                                        <a href="report.php?profile_id=<?php echo $profile_item->id ?>"><?php echo $profile_item->name ?></a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
        <?php }catch (Google_Auth_Exception $e){ ?>
            <li><?php echo $e->getMessage() ?></li>
        <?php } ?>
    </ul>
<?php include "footer.php" ?>