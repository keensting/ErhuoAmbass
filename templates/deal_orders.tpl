<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}

    <meta charset="UTF-8">
    <title>结算订单</title>
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
    <div class="Enav_bar_1">
        <table class="table">
            <tr>
                <td><input id="begin" class="form-control col-sm-6" placeholder="点击选择开始时间"></td>

                <td>|</td>
                <td>
                    <button class="btn btn-default" disabled="disabled">选择地区：</button>
                </td>
                <td><div id="pro_city" style="margin-top: 10px"></div></td>
                <td>|</td>
                <td><button class="btn btn-success" id="find_wanted" onclick="reset_condition()">重置条件</button></td>

            </tr>
            <tr>
                <td><input id="end" class="form-control col-sm-6" placeholder="点击选择结束时间"></td>
                <td>|</td>
                <td>
                    <button class="btn btn-default" disabled="disabled">选择活动：</button>
                </td>
                <td>
                    <select name="act_id" id="act_id">
                        <option value="0" selected>非活动订单</option>
                        {foreach $act_list as $v}
                            <option value="{$v['id']}">{$v['name']}</option>
                        {/foreach}

                    </select>
                </td>
                <td>|</td>
                <td><button class="btn btn-success" id="find_wanted" onclick="get_target_order_list()">开始筛选</button></td>

            </tr>
        </table>
    </div>
    <div class="condition_panel_1">
        由于订单需要执行自动筛选，请在每月10号之后使用该系统！
    </div>

    <div class="result_operate_panel">
        <table class="table text-center">
            <caption><h4 style="color: #ff4040">筛选结果</h4></caption>
            <thead>
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>身份</th>
                <th>邀请码</th>
                <th>有效订单数</th>
                <th>默认工资</th>
                <th>补贴</th>
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
        <button class="btn btn-primary" onclick="all_submit_orders(this)">统一提交</button>
    </div>


</div>


</body>
</html>