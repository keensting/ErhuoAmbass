/**
 * Created by KeenSting on 2015/10/13.
 */
//登录时候的验证
function login_check()
{
    var name=$('#name');
    var pwd=$('#pwd');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/login_check.php';
    var hash = hex_md5(pwd.val());//对密码进行加密
    console.log(hash);
    if(name.val()==''||pwd.val()=='')
    {
        $('#state').removeClass('Elogin_success').addClass('Elogin_denied');
        $('#state').fadeIn(800).delay(500).fadeOut(600);

    }
    else{

        $.post(ajaxUrl,{
            'name':name.val(),
            'pwd':hash,
        },function(data){
            //alert('here');
            if(data=='ok')
            {
                $('#state').removeClass('Elogin_denied').addClass('Elogin_success');
                $('#state').fadeIn(800).delay(500).fadeOut(600);
                //延时跳转
                setTimeout(location.href=get_url_path()+'/project/htdocs/main.php',1000);
                show_loading();
                //setInterval(location.href=get_url_path()+'/project/htdocs/main.php',8000);

            }
            else{
                $('#state').removeClass('Elogin_success').addClass('Elogin_denied');
                $('#state').fadeIn(800).delay(500).fadeOut(600);
                name.val('');
                pwd.val('');
            }
            //alert(data);
        });

    }
}
//跳转到主页
function jump_home()
{
    location.href=get_url_path()+"/project/htdocs/main.php";
}


//生成10位数的随机码
function code_generator()
{
    var result='';
    var data=['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','M','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    for(var i=0;i<10;i++)
    {
        result+=data[Math.floor(Math.random()*1000)%62];
    }
    return result;
}


//修改密码
function modify_pwd(dom)
{
    var key=$(dom).attr('value');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/modify_pwd.php';
    //alert(key);
    var state = prompt('请输入新密码(6-20位，不识别中文)：');
    if(state) {

        if (state.length >= 6 && state.length <= 20) {
            console.log(state);
            $.post(ajaxUrl,{
                'key':key,
                'pwd':state,
                'rand':code_generator(),
            },function(data)
            {
                if(data=='ok')
                {
                    alert('密码修改成功！');
                }else{
                    alert('操作失败，请联系管理员！');
                }
            })

        }
        else {
            alert('请按要求设置密码！');
        }
    }

}
//删除成员
function delete_user(dom)
{

    var key= $(dom).attr('value');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/delete_user.php';
    var state=confirm('确定删除该成员？');
    if(state)
    {
        $(dom).attr('disabled','disabled');
        $.post(ajaxUrl,{
            'key':key,
        },function(data)
        {
            if(data=='ok')
            {
                alert('删除操作成功！');
            }else{
                alert('删除失败或者重复删除！请刷新页面再试！');
            }
        });
    }

}

//降为大使
function demote_to_ambassador(dom)
{

    var key=$(dom).attr('value');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/demote_to_ambassador.php';
    var state=confirm('确定降职该主管为大使？');
    if(state)
    {
        $(dom).attr('disabled','disabled');
        $.post(ajaxUrl,{
            'key':key,
        },function(data)
        {
            if(data=='ok')
            {
                alert('操作成功！');
            }else{
                alert('操作失败或者重复操作！请刷新页面再试！');
            }
        });
    }


}

//升为主管
function promote_to_manager(dom)
{

    var key=$(dom).attr('value');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/promote_to_manager.php';
    var state=confirm('确定提升该大使为主管？');
    if(state)
    {
        $(dom).attr('disabled','disabled');
        $.post(ajaxUrl,{
            'key':key,
        },function(data)
        {
            if(data=='ok')
            {
                alert('操作成功！');
            }else{
                alert('操作失败或者重复操作！请刷新页面再试！');
            }
        });
    }

}
//按照查询条件收集数据
function data_match(auth)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/data_match.php';
    var province,city,school_name;
    var key=$('#key').val();
    var time_begin=$('#time_begin').val();
    var time_end=$('#time_end').val();
    //console.log(key);
    if(key!='')
    {
        show_loading();
        //输入了key直接查询单个人
        $.post(ajaxUrl,{
            'type':'key',
            'begin':time_begin,
            'end':time_end,
            'key':key,
        },function(data)
        {
            //console.log(data);
            if(data=='error')
            {
                hide_loading();
                alert('查询未果，请检查您的邀请码输入是否正确！');
            }
            else if(data=='auth')
            {
                hide_loading();
                alert('权限不足!');
            }else if(data=='unauthrized')
            {
                hide_loading();
                alert('只能查询管辖范围内的大使！');
            }
            else{
                var info=JSON.parse(data);
                var json=info.info;
                var school_data=info.data;
                $('#counter_data td:eq(0)').text(school_data.reg);
                $('#counter_data td:eq(1)').text(school_data.aut);
                $('#counter_data td:eq(2)').text(school_data.reg_in);
                $('#counter_data td:eq(3)').text(school_data.aut_in);
                $('#counter_data td:eq(4)').text(school_data.reg_na);
                $('#counter_data td:eq(5)').text(school_data.aut_na);
                $('#counter_name').html('<strong>'+json.school+'统计表</strong>');

                $('#lists').text('');
                var tr=$('<tr></tr>');
                var id=$('<td>搜索结果</td>');
                var name=$('<td>'+json.name+'</td>');
                var ekey=$('<td>'+json.ekey+'</td>');
                var pwd;
                if(auth==0)
                {
                    pwd=$('<td> <button class="btn btn-default" value="'+json.ekey+'"  onclick="modify_pwd(this)">修改密码</button></td>');
                }else{
                    pwd=$('<td> <button class="btn btn-default" disabled="disabled">修改密码</button></td>');
                }

                var province=$('<td>'+json.province+'</td>');
                var school=$('<td>'+json.school+'</td>');
                var identity;
                if(json.auth==1)
                {
                    identity=$('<td>主管</td>');
                }
                else{
                    identity=$('<td>大使</td>');
                }
                var level;
                if(json.level>10)
                {
                    level=$('<td><i class="manager"></i></td>')
                }else
                {
                    level=$('<td></td>');
                    for(var i=0;i<json.level;i++)
                    {
                        level.append('<i class="star"></i>');
                    }
                }
                var b_value=$('<td>'+json.b_value+'</td>');
                var reg=$('<td>'+json.reg+'</td>');
                var aut=$('<td>'+json.aut+'</td>');
                var ord=$('<td>'+json.ord+'</td>');
                var operate;
                if(json.my_auth==0)
                {
                    if(json.auth==1)
                    {
                        operate=$('<td><button class="btn btn-default" value="'+json.ekey+'"  disabled="disabled">查看团队</button>'+
                            '<button class="btn btn-default" value="'+json.ekey+'"  onclick="view_details(this)">查看业绩</button>'+
                    '<button class="btn btn-default" value="'+json.ekey+'" onclick="demote_to_ambassador(this)">降为大使</button>'+
                        '<button class="btn btn-default" value="'+json.ekey+'" onclick="delete_user(this)">删除成员</button></td>');
                    }
                    else if(json.auth==2)
                    {
                        operate=$('<td><button class="btn btn-default" value="'+json.ekey+'"  onclick="view_details(this)">查看业绩</button>'+
                    '<button class="btn btn-default" value="'+json.ekey+'" onclick="promote_to_manager(this)">升为主管</button>'+
                        '<button class="btn btn-default"  value="'+json.ekey+'" onclick="delete_user(this)">删除成员</button></td>');
                    }

                }else if(json.my_auth==1)
                {
                    if(json.auth==1)
                    {
                        operate=$('<td><button class="btn btn-default" value="'+json.ekey+'"   disabled="disabled">查看团队</button></td>');
                    }
                    else if(json.auth==2)
                    {
                        operate=$('<td><button class="btn btn-default" value="'+json.ekey+'"  onclick="view_details(this)">查看业绩</button></td>');
                    }
                }
                tr.append(id);
                tr.append(name);
                tr.append(ekey);
                tr.append(pwd);
                tr.append(province);
                tr.append(school);
                tr.append(identity);
                tr.append(level);
                tr.append(b_value);
                tr.append(reg);
                tr.append(aut);
                tr.append(ord);
                tr.append(operate);
                $('#lists').append(tr);
                $('foot_page').hide();
                hide_loading();
            }
        });
        return;
    }

    if(time_begin==''&&time_end=='')
    {
        alert('时间都不填写默认为整个时间轴！');

    }
    var as_school=$('#as_school').attr('value');
    var as_area=$('#as_area').attr('value');
    if(as_area==1&&as_school==0)
    {
        //选择了按地区查询
        var province=$('#province').val();
        if(auth==2)
        {
            alert('您没有该项操作的权限！');
            return;
        }else if(auth==0){
            if(province=='请选择'){
                alert('请选择要查询的地区！');
                return;
            }
        }

        show_loading();
        $.post(ajaxUrl,{
            'type':'area',
            'begin':time_begin,
            'end':time_end,
            'name':province,
        },function(data){
            hide_loading();
            show_match();
            var info=JSON.parse(data);
            var list=info.list;
            var counter=info.counter;
            var body=$('#result_panel');
            body.html('');
            for(var i=0;i<list.length;i++)
            {
                var json=list[i];
                var tr=$('<tr></tr>');
                tr.append('<td>'+(i+1)+'</td>');
                tr.append('<td>'+json.name+'</td>');
                tr.append('<td>'+json.ekey+'</td>');
                tr.append('<td>'+json.province+'</td>');
                tr.append('<td>'+json.school+'</td>');
                if(json.auth==1)
                {
                    tr.append('<td>主管</td>');
                }else if(json.auth==2)
                {
                    tr.append('<td>大使</td>');
                }
                if(json.level<10&&json.level>0)
                {
                    tr.append('<td>'+json.level+'星</td>');
                }else
                {
                    tr.append('<td>无</td>');
                }
                tr.append('<td>'+json.b_value+'</td>');
                tr.append('<td>'+json.reg+'</td>');
                tr.append('<td>'+json.aut+'</td>');
                tr.append('<td>'+json.ord+'</td>');

                body.append(tr);
            }
            $('#counter_data td:eq(0)').text(counter.register_all);
            $('#counter_data td:eq(1)').text(counter.authority_all);
            $('#counter_data td:eq(2)').text(counter.register_invite);
            $('#counter_data td:eq(3)').text(counter.authority_invite);
            $('#counter_data td:eq(4)').text(counter.register_nature);
            $('#counter_data td:eq(5)').text(counter.authority_nature);
            $('#counter_name').html('<strong>'+info.area+'统计表</strong>');
            //alert(data);
        })


    }else if(as_school==1&&as_area==0)
    {
        //选择了按学校查询
        var school=$('#school_name').val();
        if(school==''&&auth!=2)
        {
            alert('请填写完整的学校名！');
            return;
        }
        if(auth==2)
        {
            alert('大使只能够查询本校的信息！');
        }
        show_loading();
        $.post(ajaxUrl,{
            'type':'school',
            'begin':time_begin,
            'end':time_end,
            'name':school
        },function(data)
        {

            if(data=='date')
            {
                hide_loading();
                alert('时间区间设置错误！请检查！');
            }else if(data=='noschool')
            {
                hide_loading();
                alert('非管辖范围内的学校无权查询！');
            }
            else
            {
                var json=JSON.parse(data);
                $('#counter_data td:eq(0)').text(json.reg);
                $('#counter_data td:eq(1)').text(json.aut);
                $('#counter_data td:eq(2)').text(json.reg_in);
                $('#counter_data td:eq(3)').text(json.aut_in);
                $('#counter_data td:eq(4)').text(json.reg_na);
                $('#counter_data td:eq(5)').text(json.aut_na);
                $('#counter_name').html('<strong>'+school+'统计表</strong>');
                hide_loading();
            }
        })

    }else{
        if(auth!=0)
        {
            show_loading();
            $.post(ajaxUrl,{
                'type':'as_time',//大使,主管按时间查询自己
                'begin':time_begin,
                'end':time_end,
            },function(data){
                var json=JSON.parse(data);
                $('#my_reg').text(json.reg);
                $('#my_aut').text(json.aut);
                $('#my_ord').text(json.ord);
            })
            hide_loading();
        }else {
            alert('不选择查询类型将默认为查询全国总量！');
            show_loading();
            $.post(ajaxUrl,{
                'type':'as_time',
                'begin':time_begin,
                'end':time_end,
            },function(data){
                hide_loading();
                var counter=JSON.parse(data);
                $('#counter_data td:eq(0)').text(counter.register_all);
                $('#counter_data td:eq(1)').text(counter.authority_all);
                $('#counter_data td:eq(2)').text(counter.register_invite);
                $('#counter_data td:eq(3)').text(counter.authority_invite);
                $('#counter_data td:eq(4)').text(counter.register_nature);
                $('#counter_data td:eq(5)').text(counter.authority_nature);
                $('#counter_name').html('<strong>目标时间段全局统计表</strong>');
            });
        }
    }



}



//查看业务详情

function view_details(dom)
{
    var key=$(dom).attr('value');//获得大使的唯一key
    var url=get_url_path()+'/project/htdocs/performance.php?key='+key;
    window.open(url);

}
//获取详情的页面

function get_performance_page(dom)
{
    var page=$('#index_page').val();
    var key=$(dom).attr('value');
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/performance_page.php';
    //console.log(page);
    //console.log(key);
    show_loading();
    $.post(ajaxUrl,{
        'page':page,
        'key':key,
    },function(data){
        var info=JSON.parse(data);
        $('#current_page').text('当前为第['+info.index+']页');
        var panel=$('.p_lists');

        panel.html('');
        for(var i=0;i<info.list.length;i++)
        {
            var json=info.list[i];
            var tr=$('<tr></tr>');
            tr.append('<td>'+(i+1)+'</td>');
            tr.append('<td>'+json.nickname+'</td>');
            tr.append('<td>'+json.phone+'</td>');
            if(json.auth=='1')
            {
                tr.append('<td><button class="btn btn-success" disabled="disabled">已认证</button></td>');
            }else{
                tr.append('<td><button class="btn btn-danger" disabled="disabled">未认证</button></td>');
            }
            panel.append(tr);
        }
        hide_loading();


    });
}
//新增用户 按钮响应
function add_user(auth)
{
    if(auth==2)
    {
        alert('您没有操作的权限！');
    }else
    {
        window.open(get_url_path()+'/project/htdocs/adduser.php');

    }
}

//获取主界面的分页数据
function get_page(title)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/main_page.php';
    if(title=='admin')
    { //管理员
        show_loading();
        var index=$('#page').val();
        $.post(ajaxUrl,{
            'type':'admin',
            'index':index,
        },function(data){
            var info=JSON.parse(data);
            $('#page_index').text('当前为第['+info.index+']页');
            var body=$('#lists').html('');
            for(var i=0;i<info.list.length;i++)
            {
                var json=info.list[i];
                var tr=$('<tr></tr>');
                tr.append('<td>'+(i+1)+'</td>');
                tr.append('<td>'+json.name+'</td>');
                tr.append('<td>'+json.ekey+'</td>');
                tr.append('<td> <button class="btn btn-default" value="'+json.ekey+'"  onclick="modify_pwd(this)">修改密码</button></td>');
                tr.append('<td>'+json.province+'</td>');
                tr.append('<td>'+json.school+'</td>');
                if(json.auth==1)
                {
                    tr.append('<td>主管</td>');
                }else if(json.auth==2)
                {
                    tr.append('<td>大使</td>');
                }
                if(json.level>10)
                {
                    tr.append('<td><i class="manager"></i></td>')
                }else{
                    var level=$('<td></td>');
                    for(var k=0;k<json.level;k++)
                    {
                        level.append('<i class="star"></i>')
                    }
                    tr.append(level);
                }
                tr.append('<td>'+json.b_value+'</td>');
                tr.append('<td>'+json.reg+'</td>');
                tr.append('<td>'+json.aut+'</td>');
                tr.append('<td>'+json.ord+'</td>');
                if(json.auth==1)
                {
                    tr.append('<td><button class="btn btn-default" value="'+json.ekey+'" disabled="disabled">查看团队</button>'+
                '<button class="btn btn-default" value="'+json.ekey+'"  onclick="view_details(this)">查看业绩</button>'+
                    '<button class="btn btn-default" value="'+json.ekey+'" onclick="demote_to_ambassador(this)">降为大使</button>'+
                    '<button class="btn btn-default" value="'+json.ekey+'" onclick="delete_user(this)">删除成员</button></td>');
                }else if(json.auth==2)
                {
                    tr.append('<td><button class="btn btn-default" value="'+json.ekey+'" onclick="view_details(this)">查看业绩</button>'+
                '<button class="btn btn-default" value="'+json.ekey+'" onclick="promote_to_manager(this)">升为主管</button>'+
                    '<button class="btn btn-default"  value="'+json.ekey+'" onclick="delete_user(this)">删除成员</button></td>');
                }

                body.append(tr);
            }
        });
        hide_loading();

    }else{
        show_loading();
        var index=$('#page').val();
        $.post(ajaxUrl,{
            'type':'manager',
            'index':index,
            'province':title,
        },function(data){
            var info=JSON.parse(data);
            $('#page_index').text('当前为第['+info.index+']页');
            var body=$('#lists').html('');
            for(var i=0;i<info.list.length;i++)
            {
                var json=info.list[i];
                var tr=$('<tr></tr>');
                tr.append('<td>'+(i+1)+'</td>');
                tr.append('<td>'+json.name+'</td>');
                tr.append('<td>'+json.ekey+'</td>');
                tr.append('<td> <button class="btn btn-default" disabled="disabled" value="'+json.ekey+'"  onclick="modify_pwd(this)">修改密码</button></td>');
                tr.append('<td>'+json.province+'</td>');
                tr.append('<td>'+json.school+'</td>');
                tr.append('<td>大使</td>');
                if(json.level==0)
                {
                    tr.append('<td></td>');
                }else{
                    var level=$('<td></td>');
                    for(var k=0;k<json.level;k++)
                    {
                        level.append('<i class="star"></i>')
                    }
                    tr.append(level);
                }
                tr.append('<td>'+json.b_value+'</td>');
                tr.append('<td>'+json.reg+'</td>');
                tr.append('<td>'+json.aut+'</td>');
                tr.append('<td>'+json.ord+'</td>');
                tr.append('<td><button class="btn btn-default" value="'+json.ekey+'" onclick="view_details(this)">查看业绩</button>'+
                        '<button class="btn btn-default"  value="'+json.ekey+'" onclick="delete_user(this)">删除成员</button></td>');

                body.append(tr);
            }

        });
        hide_loading();

    }

}


//获得文件的绝对路径前端，用于区别测试服务器和发布服务器
function get_url_path()
{
    var url =location.href;
    var rule=new RegExp('online');
    var result=rule.exec(url);
    if(result=='online')
    {
        return 'http://am.erhuoapp.com/online';
    }else{
        rule=new RegExp('test');
        result=rule.exec(url);
        if(result=='test')
        {
            return 'http://am.erhuoapp.com/test';
        }else{
            alert('致命错误，请联系梁勋，QQ：707719848！');
        }
    }
}

//用户注销
function check_out()
{
    location.href=get_url_path()+'/project/htdocs/check_out.php';
}
//显示loding DIV
function show_loading()
{
    $('.loading').fadeIn(300);
}

//隐藏 loading DIV

function hide_loading()
{
    $('.loading').fadeOut(300);
}

//显示order_panel
function show_order()
{
    $('.orders_panel').fadeIn(400);
}
//隐藏order_panel
function hide_order()
{
    $('.orders_panel').fadeOut(400);
}
//显示pop_result_panel
function show_match()
{
    $('.pop_result_panel').fadeIn(400);
}
//隐藏pop_result_panel
function hide_match()
{
    $('.pop_result_panel').fadeOut(400);
}

//添加订单号
function add_order()
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/add_order_number.php';
    var id=$('#order_number').val();
    if(id=='')
    {
        alert('请填写订单号！');
        return;
    }else{
        show_loading();
        $.post(ajaxUrl,{'id':id},function(data){
            hide_loading();
            if(data=='noinfo')
            {
                alert('未查询到相关信息，请检查您的订单号！');
            }
            else if(data=='unfinish')
            {
                alert('该订单尚未付款，请稍后添加！');
                hide_order();
            }
            else if(data=='repeat')
            {
                alert('该订单已存在，请勿重复添加！');
                hide_order();
            }
            else if(data=='error')
            {
                alert('系统内部错误，请稍后再试！');
                hide_order();
            }else if(data=='type')
            {
                alert('非要求种类的订单！');
            }
            else if(data=='ok')
            {
                alert('添加成功！');
                hide_order();
            }
        });

    }



}

//查看该用户的订单详情
function show_order_details(key)
{
    var url=get_url_path()+'/project/htdocs/order_details.php?key='+key;
    window.open(url);
}
//活动公告
function activity_panel()
{
    var url=get_url_path()+'/project/htdocs/activity_boards.php';
    window.open(url);
}
//工作手册
function instruction()
{
    var url=get_url_path()+'/project/htdocs/instruction.php';
    window.open(url);
}

//设置支付宝账号
function set_zfb(dom)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/set_zfb.php';
    var accounter=prompt('请填写您的支付宝账号：');
    if(accounter){
        var resure=confirm('确认您的账号：'+accounter);
        if(resure)
        {
            $.post(ajaxUrl,{
                'name':accounter,
            },function(data){
                if(data=='ok')
                {
                    alert('设置成功！');
                    $(dom).attr('disabled','disabled');//设置成功后屏蔽这个按钮
                }else{
                    alert('设置失败，请稍后重试！');
                }
            });
        }
    }
}

//管理员分类管理
function jump_to_manager_page()
{
    var url=get_url_path()+'/project/htdocs/manager_page.php';
    window.open(url);

}
