<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <meta charset="UTF-8">
    <title>订单详情</title>
    <script type="text/javascript">
        $(function(){
            $('.loading').hide();
        })
    </script>
</head>
<body>
{include file="basic/loading.tpl"}
<div class=" " id="state"></div>
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="performance_panel">
        <table class="table">
            <caption><h4 style="color: #ff4040">订单详情</h4></caption>
            <thead>
            <tr>
                <th>序号</th>
                <th>订单号</th>
                <th>生成时间</th>
                <th>提交时间</th>
                <th>金额</th>
                <th>订单状态</th>
                <th>结算状态</th>
            </tr>
            </thead>
            <tbody>
            {if !empty($list)}
                {foreach $list as $v}
                <tr>
                    <td>{$v@index+1}</td>
                    <td>{$v['order_id']}</td>
                    <td>{$v['c_time']}</td>
                    <td>{$v['u_time']}</td>
                    <td>{$v['price']}</td>
                    <td>{$v['order_state']}</td>
                    <td>
                        {if $v['state']==0}
                            <span style="color: chartreuse">未结算</span>
                            {else}
                            <span style="color: #ff4040">已结算</span>
                        {/if}

                    </td>
                </tr>
                {/foreach}
                {else}
                暂无数据！

            {/if}
            </tbody>


        </table>
    </div>

</div>


</body>
</html>