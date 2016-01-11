<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <meta charset="UTF-8">
    <title>业绩详情</title>
    <script type="text/javascript">
        $(function(){
            $('.loading').hide();
        })
    </script>
</head>
<body>
{include file="basic/loading.tpl"}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="performance_panel">
        <table class="table">
            <caption><h3 style="color: #ff4040">业绩详情展示</h3></caption>
            <thead>
                <tr>
                    <th>序号</th>
                    <th>昵称</th>
                    <th>手机号</th>
                    <th>认证状态</th>
                </tr>
            </thead>
            <tbody class="p_lists">
            {if !empty($data.list)}
                {foreach $data.list as $v}
                    <tr>
                        <td>{$v@index+1}</td>
                        <td>{$v.nickname}</td>
                        <td>{$v.phone}</td>
                        {if $v.auth==1}
                            <td><button class="btn btn-success" disabled="disabled">已认证</button></td>
                            {else}
                            <td><button class="btn btn-danger" disabled="disabled">未认证</button></td>
                        {/if}
                    </tr>
                {/foreach}
                {else}
                <tr style="text-align: center">
                    <td></td>
                    <td>该用户没有任何业绩！</td>
                    <td></td>
                </tr>

            {/if}
            </tbody>
            <tr style="text-align: center; color: #ff4040">
                <td>共计[{$data.num}]条数据,[{$data.pages}]页</td>
                <td id="current_page">当前为第[{$data.index}]页</td>
                <td>前往第
                    <select id="index_page">
                        {if $data.pages>0}
                        {for $i=0;$i<$data.pages;$i++}
                            <option value="{$i+1}">{$i+1}</option>
                        {/for}
                        {else}
                            <option value="1">1</option>
                        {/if}
                    </select>页--->
                    <button value="{$data.key}" onclick="get_performance_page(this)">Go</button>
                </td>
            </tr>

        </table>



    </div>
</div>


</body>
</html>