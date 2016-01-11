<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <link type="text/css" rel="stylesheet" href="../style/manager.css">
    <script type="text/javascript" src="../js/manager.js"></script>
    <meta charset="UTF-8">
    <title>工资发放</title>
    <script type="text/javascript">
        $(function(){
            $('.loading').hide();
            $('.salary_detail').hide();
        })

    </script>
</head>
<body>
{include file="./basic/salary_details.tpl"}
{include file="./basic/loading.tpl"}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!-- inform-->
    <div class="salary_inform">
        工资总额：{$info['total']}RMB，共计发放：{$info['person']}人
    </div>
    <!--body-->
    <div class="salary_list_panle" >
        <table class="table">
            <caption><h3>待结算列表</h3></caption>
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>邀请码</th>
                    <th>薪资(RMB/元)</th>
                    <th>支付宝</th>
                    <th>明细</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="salary_list">
            {foreach $salary_list as $v}
                <tr id="{$v['ekey']}">
                    <td>{$v@index+1}</td>
                    <td>{$v['name']}</td>
                    <td>{$v['ekey']}</td>
                    <td>{$v['num']}</td>
                    <td>{$v['zfb_id']}</td>
                    <td><button class="btn btn-primary" value="{$v['ekey']}" onclick="get_salary_detail(this)">薪资详单</button></td>
                    <td><button class="btn btn-success" value="{$v['ekey']}" onclick="settle_salary(this)">结算</button></td>
                </tr>

            {/foreach}

            </tbody>
        </table>

    </div>
   

</div>


</body>
</html>