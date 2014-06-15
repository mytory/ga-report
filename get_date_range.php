<?php include "default.php" ?>
<?php include "header.php" ?>
<h1>기간 가져오기</h1>
<p>아래 형식대로 json을 돌려 주는 URL을 넣으세요. 그러면 해당 json을 바탕으로 기간 목록을 만듭니다.</p>
<p>프로젝트 루트 폴더에 <code>date_range.json</code> 이라는 파일을 만들어 두세요. 서버에 해당 파일 쓰기 권한이 있어야 합니다.</p>
<pre>
<?php echo htmlspecialchars('[{
    title: "1호 발행 기간",
    start_date: "2013-01-01",
    end_date: "2013-01-31"
},{
    title: "2호 발행 기간",
    start_date: "2013-02-01",
    end_date: "2013-02-15"
}]') ?>
</pre>
<form action="get_date_range_action.php">
    <div class="row">
        <label class="col-xs-1" for="url">URL</label>
        <input class="col-xs-6" type="url" name="url" id="url"/>
        <div class="col-xs-2">
            <button class="btn btn-primary">가져오기</button>
        </div>
    </div>
</form>
<?php include "footer.php" ?>
