<?php include "default.php" ?>
<?php include "header.php" ?>
<?php
$start_date = ( isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', time() - (60*60*24*7)) );
$end_date = ( isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d', time() - (60*60*24*1)) );
$results = $analytics->data_ga->get(
    'ga:' . $_GET['profile_id'],
    $start_date,
    $end_date,
    'ga:sessions'
);

if(count($results->getRows()) > 0){
    $profile_name = $results->getProfileInfo()->getProfileName();
    $rows = $results->getRows();
    $sessions = $rows[0][0];
}
?>
<h1><?php echo $profile_name ?> 통계</h1>
<p>
    날짜 :
    <?php echo date('Y-m-d(l)', strtotime($start_date)) ?>
    ~
    <?php echo date('Y-m-d(l)', strtotime($end_date)) ?>
</p>
<p>총 방문수 <?php echo number_format($sessions) ?>회</p>

<?php include "footer.php" ?>