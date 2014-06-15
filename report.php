<?php include "default.php" ?>
<?php include "header.php" ?>
<?php
// 날짜, 기간
$start_date = ( isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', time() - (60*60*24*7)) );
$end_date = ( isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d', time() - (60*60*24*1)) );
$date_range = ( ( strtotime($end_date) - strtotime($start_date) ) / ( 60*60*24 ) ) + 1;

// 매체별 방문수, 페이지뷰
$source_medium_results = ga_get_source_medium($start_date, $end_date);
$profile_name = $source_medium_results->getProfileInfo()->profileName;
$sessions = $source_medium_results->getTotalsForAllResults()['ga:sessions'];
$pageviews = $source_medium_results->getTotalsForAllResults()['ga:pageviews'];
?>
<h1>
    <?php echo $profile_name ?> 통계
    <small><?=isset($_GET['custom_range_title']) ? $_GET['custom_range_title'] : ''?></small>
</h1>
<div class="row">
    <div class="col-md-12">
        <form>
            날짜 :
            <input class="text-right" type="date" name="start_date" value="<?php echo $start_date ?>"/>
            ~
            <input class="text-right" type="date" name="end_date" value="<?php echo $end_date ?>"/>
            <input name="profile_id" type="hidden" value="<?php echo $_GET['profile_id'] ?>"/>
            <input name="custom_range_title" type="hidden"/>
            <input class="btn btn-primary" type="submit" value="검색"/>
            <?php ga_custom_ranges() ?>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul>
            <li>총 방문수 : <?php echo number_format($sessions) ?>회 (하루 평균 <?php echo number_format(round($sessions / $date_range)) ?>회)</li>
            <li>총 조회수 : <?php echo number_format($pageviews) ?>회 (하루 평균 <?php echo number_format(round($pageviews / $date_range)) ?>회)</li>
            <li>방문당 조회수 : <?php echo round($pageviews/$sessions, 2) ?>페이지</li>
        </ul>
    </div>
</div>
<div class="row">
    <?php ga_print_table($results = $analytics->data_ga->get(
        'ga:' . $_GET['profile_id'],
        $start_date,
        $end_date,
        'ga:sessions',
        array(
            'dimensions' => 'ga:medium',
            'sort' => '-ga:sessions'
        )
    ), '매체별 방문'); ?>
    <?php ga_print_table($results = $analytics->data_ga->get(
        'ga:' . $_GET['profile_id'],
        $start_date,
        $end_date,
        'ga:sessions',
        array(
            'dimensions' => 'ga:source',
            'sort' => '-ga:sessions'
        )
    ), '소스별 방문'); ?>

    <?php ga_print_table($source_medium_results, '소스와 매체별 방문') ?>
</div>
<?php include "footer.php" ?>