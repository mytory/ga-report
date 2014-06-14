<?php
session_start();
require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';
// Visit https://console.developers.google.com/ to generate your
// client id, client secret, and to register your redirect uri.
$client = new Google_Client();
$client->setApplicationName('newspaper ga report');
$client->setClientId('921572832525-3qbloc0n6pmil1iporo2deu78f5jbups.apps.googleusercontent.com');
$client->setClientSecret('Ao421TNJ0Q5fvD2HlxSD1US-');
$client->setRedirectUri('http://localhost/_MASTER/index.php');
$client->setDeveloperKey('AIzaSyCmHnBdJZluJyKN-I2BpVxQ94TWXoMYpaA');
$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if (!$client->getAccessToken()) {
    $authUrl = $client->createAuthUrl();
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
    exit;
}
$service = new Google_Service_Analytics($client);
$management_accounts = $service->management_accounts->listManagementAccounts();
$accounts = $management_accounts->getItems();
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
    foreach ($accounts as $account) { ?>
        <li>
            <a href="profiles.php?account_id=<?php echo $account->id ?>"><?php echo $account->name?></a>
            (<a href="<?php echo $account->selfLink ?>">GA에서 보기</a>)
        </li>
    <?php } ?>
    </ul>
</body>
</html>