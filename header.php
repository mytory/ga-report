<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?echo isset($title) ? $title : "구글 아날리틱스 신문 통계"?></title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .row {
        margin-bottom: 1em;
    }
    </style>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<header class="navbar navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo HOME_URL ?>">GA Report</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="<?php echo HOME_URL ?>">전체 프로필</a></li>
            <?php if(isset($_GET['profile_id'])){ ?>
                <li><a href="trend.php?profile_id=<?= $_GET['profile_id'] ?>">추세</a></li>
            <?php } ?>

            <li><a href="get_date_range.php">기간 설정</a></li>
        </ul>
    </div>
</header>
<div class="container">
