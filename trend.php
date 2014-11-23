<?php include "default.php" ?>
<?php include "header.php" ?>
<?php
$range_list = json_decode(file_get_contents('date_range.json'), true);
$range_list_11 = array_reverse(array_chunk($range_list, 11)[0]);
$data = [];

foreach ($range_list_11 as $range) {
    // 매체별 방문수, 페이지뷰
    $source_medium_results = ga_get_source_medium($range['start_date'], $range['end_date']);
    $profile_name = $source_medium_results->getProfileInfo()->profileName;
    $range['sessions'] = $source_medium_results->getTotalsForAllResults()['ga:sessions'];
    $range['pageviews'] = $source_medium_results->getTotalsForAllResults()['ga:pageviews'];
    $data[] = $range;
}
?>
<table class="table" style="table-layout: fixed">
    <thead>
    <tr>
        <th>호수</th>
        <th>기간</th>
        <th>일수</th>
        <th>방문자수</th>
        <th>하루평균 방문자수</th>
        <th>조회수</th>
        <th>하루평균 조회수</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $d) {
        $date_range = get_date_range($d['start_date'], $d['end_date']);
        ?>
        <tr>
            <th><?=$d['title']?></th>
            <td><?=$d['start_date']?>~<?=$d['end_date']?></td>
            <td><?=$date_range?></td>
            <td><?=number_format($d['sessions'])?></td>
            <td><?=number_format(round($d['sessions'] / $date_range))?></td>
            <td><?=number_format($d['pageviews'])?></td>
            <td><?=number_format(round($d['pageviews'] / $date_range))?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
