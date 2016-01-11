<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}

    <meta charset="UTF-8">
    <title>出账明细</title>
    <script type="text/javascript" src="../js/manager.js"></script>
    <link href="../style/manager.css" rel="stylesheet">
    <script type="text/javascript">
        $(function(){
            $('.loading').hide();
            $('#begin').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });
            $('#end').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });
        })
    </script>
</head>
<body>
{include file="basic/loading.tpl"}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="Enav_bar_1">
        <table class="table">
            <tr>
                <td><input id="begin" class="form-control col-sm-6" placeholder="点击选择开始时间"></td>
                <td><input id="end" class="form-control col-sm-6" placeholder="点击选择结束时间"></td>
                <td><button class="btn btn-success" id="find_wanted" onclick="download_csv_file()">下载CSV</button></td>
            </tr>
        </table>
    </div>
    <div class="result_operate_panel">
        选择时间段下载对应的csv文件
    </div>



</div>


</body>
</html>