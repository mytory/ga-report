
</div>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/select2.min.js"></script>
<link rel="stylesheet" href="bower_components/select2/select2.css"/>
<link rel="stylesheet" href="bower_components/select2/select2-bootstrap.css"/>
<script>
$('#date-range').select2({
    width: 200
}).on('change', function(e){
    var date_range = e.val.split('~');
    $('[name="start_date"]').val(date_range[0]);
    $('[name="end_date"]').val(date_range[1]);
});
</script>
</body>
</html>