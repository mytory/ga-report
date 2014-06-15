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

function ga_print_column($column, $key_name, $custom_sessions = '', $custom_pageviews = ''){
    global $sessions, $pageviews;

    if($column == 'mobile'){
        return '모바일';
    }
    if($column == 'desktop'){
        return '데스크톱';
    }
    if($column == 'tablet'){
        return '태블릿';
    }

    if( ! $custom_sessions){
        $custom_sessions = $sessions;
    }
    if( ! $custom_pageviews){
        $custom_pageviews = $pageviews;
    }

    if($key_name == 'ga:sessions'){
        return number_format($column) . ' <small>(' . round($column/$custom_sessions*100.0, 1) . '%)</small>';
    }
    if($key_name == 'ga:pageviews'){
        return number_format($column) . ' <small>(' . round($column/$custom_pageviews*100.0, 1) . '%)</small>';
    }
    if($key_name == 'ga:pageTitle'){
        if(isset(config::$removal_page_title) and config::$removal_page_title){
            return str_replace(Config::$removal_page_title, '', $column);
        }else{
            return $column;
        }
    }
    if(is_numeric($column)){
        return number_format($column);
    }else if(strstr($column, '.')){
        return "<a target='_blank' href='http://{$column}'>{$column}</a>";
    }else{
        return $column;
    }
}

function ga_print_table($results, $title = '', $opt = array()){
    global $sessions, $pageviews;
    $default = array(
        'cols' => '',
        'sessions' => $sessions,
        'pageviews' => $pageviews,
        'table_class' => '',
        'container_class' => '',
    );
    $opt = array_merge($default, $opt);
    $headers = $results->getColumnHeaders();
    $rows = $results->getRows();

    $cols = $opt['cols'];
    if( ! $cols){
        $cols = count($headers) * 2 <= 12 ? count($headers) * 2 : 12;
    }
    ?>
    <div class="col-xs-<?php echo $cols ?> clearfix <?php echo $opt['container_class'] ?>">
        <?php if($title) { ?>
            <h2><?php echo $title ?></h2>
        <?php } ?>
        <table class="table <?php echo $opt['table_class'] ?>">
            <thead>
            <tr>
                <th>순위</th>
                <?php foreach ($headers as $header) { ?>
                    <th><?php ga_korean($header['name']) ?></th>
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
                    <td><?php echo $index ?></td>
                    <?php foreach ($row as $key => $column) { ?>
                        <td class="<?php echo is_numeric($column) ? "text-right" : "" ?>">
                            <?php echo ga_print_column($column, $headers[$key]['name'], $opt['sessions'], $opt['pageviews']) ?>
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

function ga_print_article_source($results, $title = '인기 기사 방문 소스'){
    global $analytics, $start_date, $end_date;
    $headers = $results->getColumnHeaders();
    $rows = $results->getRows();
    ?>
    <div class="col-xs-12 clearfix">
        <?php if($title) { ?>
            <h2><?php echo $title ?></h2>
        <?php } ?>
        <table class="table">
            <thead>
            <tr>
                <th>순위</th>
                <?php foreach ($headers as $header) { ?>
                    <th><?php ga_korean($header['name']) ?></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $index = 0;
            foreach ($rows as $row) {
                $index++;
                $page_path = '';
                $page_sessions = '';
                $page_pageviews = '';
                ?>
                <tr style="<?php echo $index > 10 ? 'display: none' : '' ?>">
                    <td><?php echo $index ?></td>
                    <?php foreach ($row as $key => $column) { ?>
                        <td class="<?php echo is_numeric($column) ? "text-right" : "" ?>">
                            <?php echo ga_print_column($column, $headers[$key]['name']) ?>
                            <?php if($headers[$key]['name'] == 'ga:pagePath'){
                                $page_path = $column;
                            } ?>
                            <?php if($headers[$key]['name'] == 'ga:sessions'){
                                $page_sessions = $column;
                            } ?>
                            <?php if($headers[$key]['name'] == 'ga:pageviews'){
                                $page_pageviews = $column;
                            } ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr style="<?php echo $index > 10 ? 'display: none' : '' ?>">
                    <td colspan="<?php echo count($headers) ?>">
                        <?php ga_print_table($analytics->data_ga->get(
                            'ga:' . $_GET['profile_id'],
                            $start_date,
                            $end_date,
                            'ga:pageviews',
                            array(
                                'dimensions' => 'ga:source,ga:medium',
                                'sort' => '-ga:pageviews',
                                'filters' => 'ga:pagePath==' . $page_path,
                                'start-index' => 1,
                                'max-results' => 3,
                            )
                        ), '', array(
                            'cols' => 10,
                            'sessions' => $page_sessions,
                            'pageviews' => $page_pageviews,
                            'container_class' => 'pull-right'
                        )) ?>
                    </td>
                </tr>
                <tr style="<?php echo $index > 10 ? 'display: none' : '' ?>">
                    <td colspan="<?php echo count($headers) ?>">
                        <?php ga_print_table($analytics->data_ga->get(
                            'ga:' . $_GET['profile_id'],
                            $start_date,
                            $end_date,
                            'ga:pageviews',
                            array(
                                'dimensions' => 'ga:source,ga:medium,ga:deviceCategory',
                                'sort' => '-ga:pageviews',
                                'filters' => 'ga:pagePath==' . $page_path,
                                'start-index' => 1,
                                'max-results' => 6,
                            )
                        ), '', array(
                            'cols' => 10,
                            'sessions' => $page_sessions,
                            'pageviews' => $page_pageviews,
                            'container_class' => 'pull-right'
                        )) ?>
                    </td>
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
        $string = '<select id="date-range"><option value="">기간 선택</option>>';
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

function ga_korean($header_name){
    $korean = array(
        'ga:medium' => '매체',
        'ga:sessions' => '방문수',
        'ga:pageviews' => '조회수',
        'ga:source' => '소스',
        'ga:pageTitle' => '제목',
        'ga:pagePath' => '주소',
        'ga:deviceCategory' => '기기 종류',
    );
    if(isset($korean[$header_name])){
        echo $korean[$header_name];
    }else{
        echo $header_name;
    }
}