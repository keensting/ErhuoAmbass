//跳转到结算认证页面
function deal_authority()
{
    var url=get_url_path()+'/project/htdocs/deal_authority.php';
    window.open(url);
}
//搜索制定地区的大使和主管认证信息
function get_target_am_list()
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/deal_authority.php'
    var begin=$('#begin').val();
    var end=$('#end').val();
    var province=$('#province').val();
    if(begin==''||end=='')
    {
        alert('请填写完整的时间段！');
        return;
    }
    else{
        console.log(begin);
        console.log(end);
    }
    if(province==''){
        alert('请选择地区！');
        return;
    }
    else{
        console.log(province);
    }

    //设置搜索条件展示panel
    var condition=province+'--'+begin+' 至 '+end;
    $('.condition_panel').text(condition);

    //发送ajax请求
    show_loading();
    $.post(ajaxUrl,{
        'begin':begin,
        'end':end,
        'area':province,
    },function(data){

        if(data=='time')
        {
            alert('时间区间错误，请检查更正后再试！');
        }
        else{
            var list=JSON.parse(data);
            var body=$('#data_display');
            body.html('');
            for(var i=0;i<list.length;i++)
            {
                var json=list[i];
                var tr=$('<tr id="'+json.ekey+'"></tr>');
                tr.append('<td>'+(i+1)+'</td>');
                tr.append('<td>'+json.name+'</td>');
                tr.append('<td>'+json.auth+'</td>');
                tr.append('<td>'+json.ekey+'</td>');
                tr.append('<td>'+json.aut+'</td>');
                tr.append('<td>'+json.d_salary+'</td>');
                tr.append('<td><input type="number" class="form-control text-center" placeholder="填写补贴金额"></td>');
                tr.append('<td><select class="select"><option value="1">普通认证</option><option value="2">活动认证</option></select></td>');
                tr.append('<td><input type="checkbox" class="checkbox" value="'+json.ekey+'" ></td>');

                body.append(tr);
            }
            hide_loading();
        }
    })



}
//全选
function select_all()
{
    var checkbox=$(':checkbox');
    checkbox.attr('checked','true');
}
//释放
function relese_all()
{
    var checkbox=$(':checkbox');
    checkbox.removeAttr('checked');
}
//一键补贴选中用户
function extra_vage()
{
    var checked=$(':checked');
    var extra=$('.input-sm').val();
    if(extra=='')
    {
        alert('请填写要补贴的金额！');
        return;
    }
    //var list=new Array();
    for(var i=0;i<checked.length;i++)
    {
        var demo=$(checked.get(i));
        if(demo.hasClass('checkbox'))
        {
            //list.push(demo);
            //console.log(demo.val());
            var tr=$('#'+demo.val());

            //var parent=demo.parent();
            //var tr=parent.child('tr');
            var tds=tr.children('td');
            var td=$(tds.get(6));
            var num=$(tds.get(4)).text();
            var input=td.children('input');
            input.val(extra*num);
        }
    }



}

//清空补贴数据
function clean_extra_vage()
{
    var list=$('.form-control.text-center');
    list.val('');
}

//设置备注
function change_note(dom)
{
    var val=$(dom).val();
    var list=$('.select');
    list.val(val);

}

//统一提交认证
function all_submit_auth(dom)
{

    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/insert_salary_detail.php';
    var flag=confirm('数据将会被统一提交，请再次确认你的结算信息！');
    var begin=$('#begin').val();
    var end=$('#end').val();
    if(flag)
    {
        $(dom).attr('disabled','disabled');
        var body=$('#data_display');
        var tr_list=body.children('tr');
        if(tr_list.length==0)
        {
            alert('未找到要提交的列表！');
            return;
        }
        else{
            show_loading();
            for( var i=0;i<tr_list.length;i++)
            {
                var demo=$(tr_list.get(i));
                var tds=demo.children('td');
                var type;
                if($(tds.get(7)).children('select').val()==1)
                {
                    type='common authority'
                }else{
                    type='activity authority'
                }
                var note=begin+'--'+end+'--'+type;

                $.post(ajaxUrl,{
                    'type':'auth',
                    'key':$(tds.get(3)).text(),
                    'd_salary':$(tds.get(5)).text(),
                    'extra':$(tds.get(6)).children('input').val(),
                    'note':note,

                },function(data){
                    if(data=='ok')
                    {
                        console.log('ok');
                    }else if(data=='error')
                    {
                        console.log('error');
                    }
                });
            }
            hide_loading();
            alert('提交完毕！你稍后可以去工资发放里瞜一眼了~');



        }
    }
}

//统一提交订单
function all_submit_orders(dom)
{

    //return;
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/insert_salary_detail.php';
    var flag=confirm('数据将会被统一提交，请再次确认你的结算信息！');
    var begin=$('#begin').val();
    var end=$('#end').val();
    var act_id=$('#act_id').val();
    if(flag)
    {
        $(dom).attr('disabled','disabled');
        var body=$('#data_display');
        var tr_list=body.children('tr');
        if(tr_list.length==0)
        {
            alert('未找到要提交的列表！');
            return;
        }
        else{
            show_loading();
            for(var i=0;i<tr_list.length;i++)
            {
                var demo=$(tr_list.get(i));
                var tds=demo.children('td');
                var note=begin+'--'+end+'--orders salary';

                $.post(ajaxUrl,{
                    'type':'order',
                    'begin':begin,
                    'end':end,
                    'act_id':act_id,
                    'key':$(tds.get(3)).text(),
                    'd_salary':$(tds.get(5)).text(),
                    'extra':$(tds.get(6)).children('input').val(),
                    'note':note,

                },function(data){
                    if(data=='ok')
                    {
                        console.log('ok');
                    }else if(data=='error')
                    {
                        console.log(                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'error');
                    }else if(data=='fetal')
                    {
                        alert('致命错误，请立即联系开发人员！');
                    }
                });
            }
            hide_loading();
            alert('提交完毕！你稍后可以去工资发放里瞜一眼了~')




        }
    }
}

//跳转到订单处理页
function deal_orders()
{
    var url=get_url_path()+'/project/htdocs/deal_orders.php';
    window.open(url);
}
//跳转到添加活动页面
function add_activity()
{
    var url=get_url_path()+'/project/htdocs/add_activity.php';
    window.open(url);
}
//跳转到工资发放页面
function salary_give_out()
{
    var url=get_url_path()+'/project/htdocs/salary_give_out.php';
    window.open(url);
}

//获取七牛的upToken
function get_upToken()
{
    var upToken;
    var url=get_url_path()+'/project/htdocs/ajax/get_qiniu_upToken.php';
    $.post(url,{},function(data){
        upToken=data;
        $('#token').val(upToken);
    });
}

//获取到指定条件的订单业绩列表
function get_target_order_list()
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/deal_order.php';
    var begin=$('#begin').val();
    var end=$('#end').val();
    if(end==''||begin=='')
    {
        alert('开始时间和结束时间禁止为空！');
        return;
    }
    var area=$('#province').val();
    if(area=='请选择')
    {
        alert('你丫必须选择一个地区（省/直辖市）！');
        return;
    }
    var activity=$('#act_id').val();
    if(activity=='0')
    {
        alert('非活动订单将会展示所有没有绑定活动id的订单！')
    }
    show_loading();

    $.post(ajaxUrl,{
        'begin':begin,
        'end':end,
        'area':area,
        'act_id':activity,
    },function(data){
        //alert(data);
        var list=JSON.parse(data);
        var body= $('#data_display');
        body.html('');
        for(var i=0;i<list.length;i++)
        {
            var json=list[i];
            var tr=$('<tr id="'+json.ekey+'"></tr>');
            tr.append('<td>'+(i+1)+'</td>');
            tr.append('<td>'+json.name+'</td>');
            tr.append('<td>'+json.auth+'</td>');
            tr.append('<td>'+json.ekey+'</td>');
            tr.append('<td>'+json.ord+'</td>');
            tr.append('<td>'+json.ord+'</td>');
            tr.append('<td><input type="number" class="form-control text-center" placeholder="填写补贴金额"></td>');
            tr.append('<td><input type="checkbox" class="checkbox" value="'+json.ekey+'" ></td>');
            body.append(tr);
        }

        hide_loading();
    });




}

//重置订单结算页的搜索条件
function reset_condition()
{
    $('#begin').val('');
    $('#end').val('');
    $('#province').val('请选择');
    $('#act_id').val('0');
}

//get到指定大使的薪资详单
function get_salary_detail(dom)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/get_appoint_salary_details.php'
    var key=$(dom).val();
    show_loading();
    $.post(ajaxUrl,{
        'key':key,
    },function(data){
        var list=JSON.parse(data);
        var body=$('#salary_detail_list');
        body.html('');

        for(var i=0;i<list.length;i++)
        {
            var json=list[i];
            var tr=$('<tr></tr>');
            tr.append('<td>'+json.id+'</td>');
            tr.append('<td>'+json.time+'</td>');
            tr.append('<td>'+json.ekey+'</td>');
            tr.append('<td>'+json.note+'</td>');
            tr.append('<td>'+json.num+'</td>');
            tr.append('<td>'+json.type+'</td>');
            body.append(tr);
        }
        show_salary_details();


    });
    hide_loading();

}
//显示salary_detail_list
function show_salary_details()
{
    $('.salary_detail').fadeIn(800);
}

//隐藏salary_detail_list
function hide_salary_details()
{
    $('.salary_detail').fadeOut(800);
}

//结算薪资按钮响应事件
function settle_salary(dom)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/give_salary.php';
    var key=$(dom).val();
    //$('#'+key).fadeOut(800);
    $.post(ajaxUrl,{
        'key':key,
    }, function (data) {
        if(data=='ok')
        {
            alert('结算成功！');
            $('#'+key).fadeOut(800);
        }
        else if(data=='error')
        {
            alert('薪资结算失败，请及时联系开发人员！');
        }
    })


}

//活动状态管理
function change_activity_state()
{
    var url=get_url_path()+'/project/htdocs/change_activity_state.php';
    window.open(url);
}

//活动管理页选择类型
function change_list_type(dom,type)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/change_activity_list_type.php';
    //alert(type);
    $('#type').text($(dom).text());
    var head=$('#head');
    var body=$('#body');
    head.html('');
    body.html('');
    if(type=='all')
    {
        var tr=$('<tr></tr>');
        tr.append('<td>活动编号</td>');
        tr.append('<td>活动名称</td>');
        tr.append('<td>活动大图</td>');
        tr.append('<td>活动时间</td>');
        tr.append('<td>上线状态</td>');
        tr.append('<td>大使开放</td>');
        tr.append('<td>相关操作</td>');
        head.append(tr);
        $.post(ajaxUrl,{
            'type':type,
        },function(data){
            var list=JSON.parse(data);
            for(var i=0;i<list.length;i++)
            {
                var obj=list[i];
                var state,is_open;
                if(obj['state']==1)
                {
                    a_state='<p  style="color: greenyellow">已上线</p>';
                }else
                {
                    a_state='<p style="color: #ff4040">未上线</p>';
                }

                if(obj['is_open']==1)
                {
                    is_open='<p style="color: greenyellow">已开放</p>';
                }else {
                    is_open='<p style="color: #ff4040">未开放</p>';
                }
                var btn_group='<td><div class="btn-group"><button class="btn btn-primary" value="'+obj['id']+'" state="'+obj['state']+'" onclick="switch_state(this,0)" >上线切换</button><button class="btn btn-primary" state="'+obj['is_open']+'"  value="'+obj['id']+'" onclick="switch_state(this,1)">开放切换</button><button class="btn btn-danger">编辑</button></div></td>';
                body.append('<tr><td>'+obj['id']+'</td><td>'+obj['name']+'</td><td><img width="250" src="http://7xnquu.com1.z0.glb.clouddn.com/'+obj['img']+'"></td><td>起：'+obj['time_begin']+'<br>止：'+obj['time_end']+'</td><td>'+a_state+'</td><td>'+is_open+'</td>'+btn_group+'</tr>');
            }
        });

    }else if(type=='online'||type=='offline')
    {
        var tr=$('<tr></tr>');
        tr.append('<td>活动编号</td>');
        tr.append('<td>活动名称</td>');
        tr.append('<td>活动大图</td>');
        tr.append('<td>活动时间</td>');
        tr.append('<td>大使开放</td>');
        tr.append('<td>相关操作</td>');
        head.append(tr);
        $.post(ajaxUrl,{
            'type':type,
        },function(data){
            var list=JSON.parse(data);
            for(var i=0;i<list.length;i++)
            {
                var obj=list[i];
                var state,is_open;
                if(obj['is_open']==1)
                {
                    is_open='<p style="color: greenyellow">已开放</p>';
                }else {
                    is_open='<p style="color: #ff4040">未开放</p>';
                }
                var btn_group='<td><div class="btn-group"><button class="btn btn-primary" value="'+obj['id']+'" state="'+obj['state']+'" onclick="switch_state(this,0)" >下线</button><button class="btn btn-primary" value="'+obj['id']+'" state="'+obj['is_open']+'" onclick="switch_state(this,1)">开放切换</button><button class="btn btn-danger">编辑</button></div></td>';
                body.append('<tr><td>'+obj['id']+'</td><td>'+obj['name']+'</td><td><img width="250" src="http://7xnquu.com1.z0.glb.clouddn.com/'+obj['img']+'"></td><td>起：'+obj['time_begin']+'<br>止：'+obj['time_end']+'</td><td>'+is_open+'</td>'+btn_group+'</tr>');
            }
        });
    }else  if(type=='amb')
    {
        var tr=$('<tr></tr>');
        tr.append('<td>活动编号</td>');
        tr.append('<td>活动名称</td>');
        tr.append('<td>活动大图</td>');
        tr.append('<td>活动时间</td>');
        tr.append('<td>上线状态</td>');
        tr.append('<td>相关操作</td>');
        head.append(tr);
        $.post(ajaxUrl,{
            'type':type,
        },function(data){
            var list=JSON.parse(data);
            for(var i=0;i<list.length;i++)
            {
                var obj=list[i];
                var state,is_open;
                if(obj['state']==1)
                {
                    a_state='<p  style="color: greenyellow">已上线</p>';
                }else
                {
                    a_state='<p style="color: #ff4040">未上线</p>';
                }

                var btn_group='<td><div class="btn-group"><button class="btn btn-primary" value="'+obj['id']+'" state="'+obj['state']+'" onclick="switch_state(this,1)" >开放切换</button><button class="btn btn-danger">编辑</button></div></td>';
                body.append('<tr><td>'+obj['id']+'</td><td>'+obj['name']+'</td><td><img width="250" src="http://7xnquu.com1.z0.glb.clouddn.com/'+obj['img']+'"></td><td>起：'+obj['time_begin']+'<br>止：'+obj['time_end']+'</td><td>'+a_state+'</td>'+btn_group+'</tr>');

            }
        });
    }

}

//切换活动的在线(是否对大使开放)状态
function switch_state(dom,type)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/switch_state.php';
    var id=$(dom).attr('value');
    var value=$(dom).attr('state');
    //alert(value);
    $.post(ajaxUrl,{
        'type':type==0?'state':'is_open',
        'id':id,
        'value':value
    },function(data){
        if(data=='ok')
        {
            alert('状态切换成功！');
        }else{
            alert('操作失败，来小黑屋找我叨叨~');
        }
    });
    $(dom).attr('disabled','disabled');

}




//跳转到出账明细
function jump_to_expend_details()
{
    var url=get_url_path()+'/project/htdocs/expend_details.php';
    window.open(url);
}

//下载csv文件
function download_csv_file()
{
    var start=$('#begin').val();
    var end=$('#end').val();
    if(start==''||end=='')
    {
        alert('时间段不能有空！');
        return;
    }
    location.href=get_url_path()+'/project/htdocs/ajax/download_expend_csv_file.php?start='+start+'&end='+end;

    //var url=get_url_path()+'/project/htdocs/download_expend_csv_file.php';



}