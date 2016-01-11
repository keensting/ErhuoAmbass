<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}

    <meta charset="UTF-8">
    <title>结算认证</title>
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
            $('#pro_city').ProvinceCity();
        })
    </script>
</head>
<body>
{include file="basic/loading.tpl"}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="Enav_bar">
        <table class="table">
            <tr>
                <td><input id="begin" class="form-control col-sm-6" placeholder="点击选择开始时间"></td>
                <td><input id="end" class="form-control col-sm-6" placeholder="点击选择结束时间"></td>
                <td>|</td>
                <td>
                    <button class="btn btn-default" disabled="disabled">选择地区：</button>

                </td>
                <td><div id="pro_city" style="margin-top: 10px"></div></td>
                <td>|</td>
                <td><button class="btn btn-success" id="find_wanted" onclick="get_target_am_list()">开始筛选</button></td>

            </tr>
        </table>
    </div>
    <div class="condition_panel">
       请设置筛选条件！
    </div>

    <div class="result_operate_panel">
        <table class="table">
            <caption><h4 style="color: #ff4040">筛选结果</h4></caption>
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>身份</th>
                    <th>邀请码</th>
                    <th>认证数</th>
                    <th>默认工资</th>
                    <th>补贴</th>
                    <th>备注</th>
                    <th>选中</th>
                </tr>
            </thead>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <input class="input-sm col-sm-4" type="number" placeholder="补贴：元/人">
                    <button class="btn btn-success" onclick="extra_vage()">一键补贴</button>
                    <button class="btn btn-success" onclick="clean_extra_vage()">清空</button>
                </td>
                <td>
                    <select onchange="change_note(this)">
                        <option value="1">普通认证</option>
                        <option value="2">活动认证</option>
                    </select>
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-success" onclick="select_all()">全选</button>
                        <button class="btn btn-success" onclick="relese_all()">清空</button>
                    </div>
                </td>
            </tr>
            <tbody id="data_display">
            </tbody>

        </table>
    </div>

    <div class="operate_nav_list">
        <button class="btn btn-primary" onclick="all_submit_auth(this)">统一提交</button>
    </div>


</div>


</body>
</html>