<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}

    <meta charset="UTF-8">
    <title>添加活动</title>
    <script type="text/javascript" src="../js/manager.js"></script>
    <link href="../style/manager.css" rel="stylesheet">
    <script type="text/javascript">
        $(function(){
            $('#begin').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1,
            });
            $('#end').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1,
            });

            });


    </script>
</head>
<body>
{*{include file="basic/loading.tpl"}*}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="Eadd_user_panel">
        <form method="post" action="./ajax/add_activity_files.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>活动名称</label>
                <input name="name" id="name" class="form-control" placeholder="填写活动名">
            </div>
            <div class="form-group">
                <label>活动主题</label>
                <input name="theme" id="theme" class="form-control" placeholder="填写活动主题">
            </div>
            <div class="form-group">
                <label>开始时间</label>
                <input name="begin" id="begin" class="form-control" placeholder="选择活动开始时间">
            </div>
            <div class="form-group">
                <label>结束时间</label>
                <input name="end" id="end" class="form-control" placeholder="选择活动结束时间">
            </div>
            <div class="form-group">
                <label>活动宣传图</label>
                <input name="file" id="file" type="file" class="form-control">
            </div>

            <div class="form-group">
                <label>活动规则图</label>
                <input name="rule" id="rule" type="file" class="form-control">
            </div>
            <div class="form-group">
                <label>活动内容</label>
                <input name="content" id="content" type="file" class="form-control">
            </div>
            <div class="form-group">
                <label>七牛upToken</label>
                <input name="token" id="token" class="form-control" placeholder="点击‘获取upToken’自动填充">
            </div>
            <div class="form-group">
                <label>是否上线</label>
                <select class="form-control" name="state" id="state">
                    <option value="1" selected>是</option>
                    <option value="0">否</option>
                </select>
            </div>
            <div class="form-group">
                {*在form中的button必须注明type，否则默认都是提交*}
                <button class="btn btn-primary" type="button" onclick="get_upToken()">获取upToken</button>
                <button class="btn btn-success" type="submit">提交</button>
            </div>
        </form>
    </div>



</div>


</body>
</html>