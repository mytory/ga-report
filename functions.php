<?php
/**
 * 변수의 구성요소를 리턴받는다.
 */
function getPrintr($var, $title = null) {
    $dump = '';
    $dump .= '<div align="left">';
    $dump .= '<pre style="background-color:#000; color:#00ff00; padding:5px; font-size:14px;">';
    if ($title) {
        $dump .= "<strong style='color:#fff'>{$title} :</strong> \n";
    }
    $dump .= print_r($var, TRUE);
    $dump .= '</pre>';
    $dump .= '</div>';
    $dump .= '<br />';
    return $dump;
}

/**
 * 변수의 구성요소를 출력한다.
 */
function printr($var, $title = null) {
    $dump = getPrintr($var, $title);
    echo $dump;
}

/**
 * 변수의 구성요소를 출력하고 멈춘다.
 */
function printr2($var, $title = null) {
    printr($var, $title);
    exit;
}

function ga_get_source_medium($start_date, $end_date){
    global $analytics;
    $results = $analytics->data_ga->get(
        'ga:' . $_GET['profile_id'],
        $start_date,
        $end_date,
        'ga:sessions,ga:pageviews',
        array(
            'dimensions' => 'ga:source,ga:medium',
            'sort' => '-ga:pageviews'
        )
    );
    return $results;
}

/**
 * 특정 기간 총 방문수와 페이지뷰
 * @param $start_date
 * @param $end_date
 * @return mixed
 */
function ga_get_total($start_date, $end_date){
    global $analytics;
    $results = $analytics->data_ga->get(
        'ga:' . $_GET['profile_id'],
        $start_date,
        $end_date,
        'ga:sessions,ga:pageviews'
    );
    return $results;
}

function ga_print_column($column){
    if(is_numeric($column)){
        return number_format($column);
    }else if(strstr($column, '.')){
        return "<a target='_blank' href='http://{$column}'>{$column}</a>";
    }else{
        return $column;
    }
}

function ga_print_table($results, $title = ''){
    $headers = $results->getColumnHeaders();
    $rows = $results->getRows();
    $sessions = $results->getTotalsForAllResults()['ga:sessions'];
    if(isset($results->getTotalsForAllResults()['ga:pageviews'])){
        $pageviews = $results->getTotalsForAllResults()['ga:pageviews'];
    }
    $cols = count($headers) * 2 <= 12 ? count($headers) * 2 : 12;

    ?>
    <div class="col-xs-<?php echo $cols ?> clearfix">
        <?php if($title) { ?>
            <h2><?php echo $title ?></h2>
        <?php } ?>
        <table class="table">
            <thead>
            <tr>
                <?php foreach ($headers as $header) { ?>
                    <th><?php echo $header['name'] ?></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $index = 0;
            foreach ($rows as $row) {
                $index++;
                ?>
                <tr style="<?php echo $index > 10 ? 'display: none' : '' ?>">
                    <?php foreach ($row as $key => $column) { ?>
                        <td class="<?php echo is_numeric($column) ? "text-right" : "" ?>">
                            <?php echo ga_print_column($column) ?>
                            <?php if($headers[$key]['name'] == 'ga:sessions'){ ?>
                                <small>(<?php echo round($column/$sessions*100.0, 2) ?>%)</small>
                            <?php } ?>
                            <?php if($headers[$key]['name'] == 'ga:pageviews'){ ?>
                                <small>(<?php echo round($column/$pageviews*100.0, 2) ?>%)</small>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php if(count($rows) > 10){ ?>
            <button class="pull-right btn btn-default" onclick="$(this).prev().find('tr:hidden').show(); $(this).remove()">+ 다 보기</button>
        <?php } ?>
    </div>
    <?php
}

function ga_custom_ranges(){
    echo ga_get_custom_ranges();
}

function ga_get_custom_ranges(){
    $range_list = json_decode(file_get_contents('date_range.json'), true);
    if($range_list) {
        $string = '<select id="date-range">';
        foreach ($range_list as $range) {
            if( ! isset($range['start_date']) or  ! isset($range['end_date'])){
                echo "date_range.json 형식이 잘못됐습니다. start date나 end date가 없는 아이템이 있습니다.";
                return false;
            }
            if( ! isset($range['title']) or empty($range['title'])){
                $range['title'] = $range['start_date'] . '~' . $range['end_date'];
            }
            $string .= "<option value='{$range['start_date']}~{$range['end_date']}'>{$range['title']}</option>";
        }
        $string .= "</select>";
        return $string;
    }
}