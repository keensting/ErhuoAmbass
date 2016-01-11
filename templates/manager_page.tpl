<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
     <link type="text/css" rel="stylesheet" href="../style/manager.css">
    <script type="text/javascript" src="../js/manager.js"></script>
    <meta charset="UTF-8">
    <title>分类管理</title>
    <script type="text/javascript">
        $(function() {
            $('.list_panel button').hide();
            $('#p4').click(function(){
                $('.list_panel button').hide();
                $('#p41').fadeIn(800);
                $('#p42').fadeIn(800);
            });
            $('#p1').click(function() {
                $('.list_panel button').hide();
                $('#p11').fadeIn(800);
                $('#p12').fadeIn(800);
            });
            $('#p6').click(function(){
                $('.list_panel button').hide();
                salary_give_out();

            });
            $('#p5').click(function(){
                $('.list_panel button').hide();
                jump_to_expend_details();
            })
        })
    </script>
</head>
<body>
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="manager_panel">
        <div class="panel-heading">
            <h3>管理员操作中心</h3>
        </div>
        <br>
        <table class="table_panel">
            <tr>
                <td>
                   <div id="p1" class="table_block">活动管理</div>
                </td>
                <td>
                   <div id="p2" class="table_block">删除审核</div>
                </td>
                <td>
                   <div id="p3" class="table_block">新增学校</div>
                </td>
            </tr>
            <tr>
                <td>
                   <div id="p4" class="table_block">工资结算</div>
                </td>
                <td>
                   <div id="p5" class="table_block">出账明细</div>
                </td>
                <td>
                   <div id="p6" class="table_block">工资发放</div>
                </td>
            </tr>

        </table>


        <div class="list_panel">
            <button id="p11" class="btn-success btn" onclick="add_activity()">添加活动</button>
            <button id="p12" class="btn-success btn" onclick="change_activity_state()">改变状态</button>
            <button id="p41" class="btn-success btn" onclick="deal_orders()">结算订单</button>
            <button id="p42" onclick="deal_authority()" class="btn-success btn">结算认证</button>
        </div>





    </div>

</div>


</body>
</html>