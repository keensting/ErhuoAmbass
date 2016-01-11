<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <script type="text/javascript" src="../../datepicker/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/erhuo.js"></script>
    <script type="text/javascript" src="../js/activity.js"></script>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/activity.css" rel="stylesheet">
    <link rel="Shortcut Icon" href="http://7xngw8.com1.z0.glb.clouddn.com/title.png">

    <meta charset="UTF-8">
    <title>活动公告栏</title>
    <script type="text/javascript">
//        $(function(){
//            $('.loading').hide();
//        })
        function resize()
        {
            var x=900;
            window.resizeTo(x,800);
        }
    </script>

</head>
<body onresize="resize()">
<div class="container">
    {*头部*}
    <div class="page-header" style="border-color: #ff4040">
        <div class="form-group" style="height: 60px">
            <div class="header_img"></div>
            <div class="header_title">
                <strong><h3>贰货活动公告栏</h3></strong>
            </div>
        </div>

    </div>
    {*活动列表*}
    <div class="nav-tabs text-center" style="border-color: #ff4040">
        {foreach $act_list as $v}
        <div class="navbar-btn">
            <i class="carrots_left"></i>
            <i class="carrots_right"></i>
            {if $v@index==0}
            <span style="color: red">New</span>
            <button class="btn btn-success"  value="{$v['id']}" onclick="reload_info(this)">{$v['name']}</button>
            <span style="color: red">New</span><br>
                {else}
                <img class="big_carrots">
                <button class="btn btn-success" value="{$v['id']}" onclick="reload_info(this)">{$v['name']}</button>
                <img class="big_carrots">
            {/if}

        </div>

        {/foreach}
        {*<div class="navbar-btn">*}
            {*<i class="carrots_left"></i>*}
            {*<img class="big_carrots">*}
                {*<a href="#" target="_blank">万圣节活动</a>*}
            {*<img class="big_carrots">*}
            {*<i class="carrots_right"></i>*}
        {*</div>*}
        {*<div class="navbar-btn">*}
            {*<i class="carrots_left"></i>*}
            {*<img class="big_carrots">*}
                {*<a href="#" target="_blank">校园书屋活动</a>*}
            {*<img class="big_carrots">*}
            {*<i class="carrots_right"></i>*}
        {*</div>*}
    </div>
    {$new=$act_list[0]}

    {*最新活动*}
    <div class="panel">
        <div class="page-header text-center">
            <i class="carrots_left"></i>
            <i class="carrots_right"></i>
            <h3 style="color: #ff4040">活动详情</h3>
            <br><br>
            <img src="http://7xnquu.com1.z0.glb.clouddn.com/{$new['img']}" width="85%" height="140">

        </div>


        <div class="panel-body">
            <div class="border_style">
            <table class="table">
                <thead>
                    <tr>
                        <td style="width: 15%"></td>
                        <td style="width: 85%"></td>
                    </tr>
                </thead>
                <tbody id="details">
                    <tr>
                        <td>活动名称</td>
                        <td id="name">{$new['name']}</td>
                    </tr>
                    <tr>
                        <td>活动主题</td>
                        <td id="theme">{$new['theme']}</td>
                    </tr>
                    <tr>
                        <td>活动时间</td>
                        <td id="time">{$new['time_begin']}-{$new['time_end']}</td>
                    </tr>
                    <tr>
                        <td>活动内容</td>
                        <td id="content">
                            <img src="http://7xnquu.com1.z0.glb.clouddn.com/{$new['content']}">

                        </td>
                    </tr>
                    <tr>
                        <td>活动规则</td>
                        <td id="rule">
                            <img src="http://7xnquu.com1.z0.glb.clouddn.com/{$new['rule']}">
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="foot_page">
        <center>erhuoapp.com&nbsp;&nbsp;All Rights Reserved</center>
    </div>
</div>


</body>
</html>