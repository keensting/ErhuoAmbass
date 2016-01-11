<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <meta charset="UTF-8">
    <title>成员管理</title>
    <script type="text/javascript">
        $(function(){
            $('.pop_result_panel').hide();
            $('.loading').hide();
            $('.orders_panel').hide();
            $('#school_name').hide();
            $('.datepicker').datetimepicker({
                //showOn: "button",
                //buttonImage: "./css/images/icon_calendar.gif",
                //buttonImageOnly: true,
//                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });
            $('#reset').click(function() {
                //清空时间区间
                $('.datepicker').val('');
                $('#school_name').val('');
                $('#as_area').removeClass('btn-success').addClass('btn-default');
                $('#as_school').removeClass('btn-success').addClass('btn-default');
                $('#province').val('请选择');
                $('#key').val('');
                $('#city').html('<option>请选择</option>');
            })
            $('.pro_city').ProvinceCity();//省市级联
            $('#as_area').click(function() {
                var flag_area=$(this).hasClass('btn-success');//判断点击状态
                if(!flag_area)//没有被选中
                {
                    $(this).attr('value','1');//记录激活状态
                    $(this).removeClass('btn-default').addClass('btn-success');
                    $('#as_school').removeClass('btn-success').addClass('btn-default');
                    $('#as_school').attr('value','0');
                    $('.pro_city').show();

                    $('#school_name').hide();
                }
                else{
                    $(this).removeClass('btn-success').addClass('btn-default');
                    $(this).attr('value','0');
                }
            })

            $('#as_school').click(function() {
                var flag_school=$(this).hasClass('btn-success');//判断点击状态
                if(!flag_school)//没有被选中
                {
                    $(this).attr('value','1');
                    $(this).removeClass('btn-default').addClass('btn-success');
                    $('#as_area').removeClass('btn-success').addClass('btn-default');
                    $('#as_area').attr('value','0');
                    $('.pro_city').hide();

                    $('#school_name').show();

                }
                else
                {
                    $(this).removeClass('btn-success').addClass('btn-default');
                    $(this).attr('value','0');
                }
            })



        })


    </script>
</head>
<body>
{*搜索展示界面*}
{include file="basic/match_panel.tpl"}
{*载入等待界面*}
{include file="basic/loading.tpl"}
{*添加订单号*}
{include file="basic/orders.tpl"}
{*展示B值的div*}
<div class=" b_value_panel" title="这里展示的是您的B值，B值=认证数/机器码数,是用来防止作弊的数量指标，B值理想状态为1，B值越高，说明您作弊的可能性越大，您获得的报酬就会相应的有所减少！详情请见《工作手册》">
    {$session['userinfo']['b_value']}
</div>
<div class="container">
    <!--头-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--搜索布局-->
    <div class="Esearch_condition">
        <table class="Enav_table">
            <tr>
                <td><input id="time_begin" class="datepicker form-control" placeholder="点击选择开始时间"></td>
                <td><label id="as_area" class="btn btn-default" >按照地区查询</label></td>
                <td><input id="key" class="form-control" placeholder="输入邀请码查询指定成员(范围查询不填)"></td>
                <td><label class="btn btn-default" id="reset">重置查询条件</label></td>
                <td><button class="btn btn-primary" onclick="activity_panel()">活动公告</button></td>
            </tr>
            <tr>
                <td><input id="time_end" class="datepicker form-control" placeholder="点击选择结束时间"></td>
                <td><label id="as_school" class="btn btn-default">按照学校查询</label></td>
                <td>
                    <div class="pro_city"></div>
                    <input id="school_name" class="form-control col-sm-4" placeholder="请输入完整的校名，如：清华大学">
                </td>
                <td><label class="btn btn-success" id="search" onclick="data_match({$session['userinfo']['auth']})" title="查询规则请见工作手册！">查询</label></td>
                <td><label class="btn btn-primary" onclick="add_user({$session['userinfo']['auth']})">添加成员</label></td>
            </tr>

        </table>
    </div>
    <!--统计部分-->
    <div class="Ecounter_tab">
        <table>
            <caption id="counter_name"><strong>全局统计表</strong></caption>
            <tr>
                <td>注册数</td>
                <td>认证数</td>
                <td>邀请注册数</td>
                <td>邀请认证数</td>
                <td>自然注册数</td>
                <td>自然认证数</td>
            </tr>
            <tr id="counter_data">
                <td>{$counter.register_all}</td>
                <td>{$counter.authority_all}</td>
                <td>{$counter.register_invite}</td>
                <td>{$counter.authority_invite}</td>
                <td>{$counter.register_nature}</td>
                <td>{$counter.authority_nature}</td>
            </tr>

        </table>
        <div class="Ecounter_tab_right form-group">
            {if $session['userinfo']['auth']==0}
                <button class="btn btn-success" disabled="disabled">全部</button>
                <button class="btn btn-success" onclick="instruction()">工作手册</button>

            {elseif $session['userinfo']['auth']==1 }
                <button class="btn btn-success" disabled="disabled">主管</button>
                <button class="btn btn-success" onclick="instruction()">工作手册</button>

            {elseif $session['userinfo']['auth']==2 }
                <button class="btn btn-success" disabled="disabled">大使</button>
                <button class="btn btn-success" onclick="instruction()">工作手册</button>

            {/if}
            {if $session['userinfo']['zfb_id']==''}
                <button class="btn btn-danger" onclick="set_zfb(this)" title="您的支付宝账号尚未设置！请及时完善，方便您收款！">支付宝</button>
            {/if}
        </div>

    </div>
    <!--数据展示部分-->
    <div class="Edata_display">
        <table class="table">
            <tr style="color: #ff4040;">
                <td>序号</td>
                <td>昵称</td>
                <td>邀请码</td>
                <td>后台登录密码</td>
                <td>地区</td>
                <td>学校</td>
                <td>身份</td>
                <td>星级</td>
                <td title="认证数/机器码数">B值</td>
                <td>注册数</td>
                <td>认证数</td>
                <td>订单数</td>
                <td>操作</td>
            </tr>
            <tr>
                <td>我自己</td>
                <td>{$session['userinfo']['name']}</td>
                <td>{$session['userinfo']['ekey']}</td>
                <td><button class="btn btn-default" value="{$session['userinfo']['ekey']}" onclick="modify_pwd(this)">修改密码</button></td>
                <td>{$session['userinfo']['province']}</td>
                <td>{$session['userinfo']['school']}</td>
                <td>
                    {if $session['userinfo']['auth']==0}
                        管理员
                    {elseif $session['userinfo']['auth']==1}
                        主管
                    {elseif $session['userinfo']['auth']==2}
                        大使
                    {/if}
                </td>
                <td>
                    {if $session['userinfo']['level']==21}
                        <i class="admin"></i>
                    {elseif $session['userinfo']['level']==11}
                        <i class="manager"></i>
                    {elseif $session['userinfo']['level']<10}
                        {for $i=0;$i<$session['userinfo']['level'];$i++}
                            <i class="star"></i>
                        {/for}
                    {/if}
                </td>
                <td>{$session['userinfo']['b_value']}</td>
                <td id="my_reg">{$session['userinfo']['register']}</td>
                <td id="my_aut">{$session['userinfo']['authority']}</td>
                <td id="my_ord">{$session['userinfo']['orders']}</td>
                <td>
                    <div class="btn-group">
                        {if $session['userinfo']['auth']==1}
                            <button class="btn btn-default" disabled="disabled">地区主管</button>
                            <button class="btn btn-default"  value="{$session['userinfo']['ekey']}"  onclick="view_details(this)">业绩详情</button>
                            <button class="btn btn-success" onclick="show_order()">添加订单</button>
                            <button class="btn btn-success" onclick="show_order_details({$session['userinfo']['ekey']})">订单详情</button>
                            {elseif $session['userinfo']['auth']==2}
                            <button class="btn btn-default" disabled="disabled">普通大使</button>
                        <button class="btn btn-default"  value="{$session['userinfo']['ekey']}"  onclick="view_details(this)">业绩详情</button>
                            <button class="btn btn-success" onclick="show_order()">添加订单</button>
                            <button class="btn btn-success" onclick="show_order_details({$session['userinfo']['ekey']})">订单详情</button>

                        {elseif $session['userinfo']['auth']==0}
                        <button class="btn btn-primary" disabled="disabled">管理员</button>
                        <button class="btn btn-primary" onclick="jump_to_manager_page()">分类管理</button>
                        {/if}
                    </div>
                </td>
            </tr>
            <tbody id="lists">
                {*<tr>{print_r($list)}</tr>*}
                {if !empty($list['list'])}
                    {foreach $list['list'] as $v}

                    <tr>
                        <td>{$v@index+1}</td>
                        <td>{$v['name']}</td>
                        <td>{$v['ekey']}</td>
                        <td>
                            {if $session['userinfo']['auth']==0}
                            <button class="btn btn-default" value="{$v['ekey']}"  onclick="modify_pwd(this)">修改密码</button>
                            {else}
                            <button class="btn btn-default" value="{$v['ekey']}" disabled="disabled">修改密码</button>
                            {/if}

                        </td>
                        <td>{$v['province']}</td>
                        <td>{$v['school']}</td>
                        <td>
                            {if $v['auth']==0}
                                管理员
                            {elseif $v['auth']==1}
                                主管
                            {elseif $v['auth']==2}
                                大使
                            {/if}
                        </td>
                        <td>
                            {if $v['level']==21}
                                <i class="admin"></i>
                            {elseif  $v['level']==11}
                                <i class="manager"></i>
                            {elseif $v['level']<10}
                                {for $i=0;$i< $v['level'];$i++}
                                    <i class="star"></i>
                                {/for}
                            {/if}
                        </td>
                        <td>{$v['b_value']}</td>
                        <td>{$v['reg']}</td>
                        <td>{$v['aut']}</td>
                        <td>{$v['ord']}</td>
                        <td>
                            <div class="btn-group">
                                {*管理员权限*}
                                {if $session['userinfo']['auth']==0}
                                    {if $v['auth']==1}
                                            <button class="btn btn-default" value="{$v['ekey']}" disabled="disabled">查看团队</button>
                                            <button class="btn btn-default" value="{$v['ekey']}"  onclick="view_details(this)">查看业绩</button>
                                            <button class="btn btn-default" value="{$v['ekey']}" onclick="demote_to_ambassador(this)">降为大使</button>
                                        <button class="btn btn-default" value="{$v['ekey']}" onclick="delete_user(this)">删除成员</button>
                                        {elseif $v['auth']==2}
                                            <button class="btn btn-default" value="{$v['ekey']}" onclick="view_details(this)">查看业绩</button>
                                            <button class="btn btn-default" value="{$v['ekey']}" onclick="promote_to_manager(this)">升为主管</button>
                                        <button class="btn btn-default"  value="{$v['ekey']}" onclick="delete_user(this)">删除成员</button>
                                    {/if}

                                {elseif $session['userinfo']['auth']==1}
                                    <button class="btn btn-default" value="{$v['ekey']}" onclick="view_details(this)">查看业绩</button>
                                    <button class="btn btn-default"  value="{$v['ekey']}" onclick="delete_user(this)">删除成员</button>
                                {/if}
                            </div>

                        </td>
                    </tr>

                    {/foreach}
                {/if}
            </tbody>
        </table>

    </div>

</div>
<!--分页部分-->

{if $session['userinfo']['auth']!=2}
    <div class="foot_page">
        <table class="table">
            <tr style="text-align: center;color: #ff4040">

                <td>共计[{$list['num']}]条数据</td>
                <td>共计[{$list['pages']}]页</td>
                <td id="page_index">当前为第[{$list['index']}]页</td>
                <td>前往第
                    <select id="page">
                        {for $i=0;$i<$list['pages'];$i++}
                            <option value="{$i+1}">{$i+1}</option>
                        {/for}
                    </select>页--->
                    {if $session['userinfo']['auth']==0}
                        <button onclick="get_page('admin')">GO</button>
                    {else}
                        <button onclick="get_page('{$session['userinfo']['province']}')">GO</button>
                    {/if}
                </td>
            </tr>
        </table>
    </div>
{/if}




</body>
</html>