/**
 * Created by keensting on 15-11-16.
 */
//展开或者收起评论
function switch_list(id)
{
    if(tmp_id=='0')
    {
        tmp_id=id;
    }
    if(id!=tmp_id)
    {
        $('#'+tmp_id).text('展开评论');
        $('.comment_panel').slideUp(600);
        $('#'+id).text('收起评论');
        get_comment(id);
        $('.comment_panel.'+id).slideDown(600);
        flag=true;
        tmp_id=id;
    }else {
        if (flag) {
            $('#' + id).text('展开评论');
            $('.comment_panel').slideUp(600);
            flag = false;
        } else {
            $('#' + id).text('收起评论');
            get_comment(id);
            $('.comment_panel.' + id).slideDown(600);
            flag = true;
        }
    }
}

//请求数据
function require_data()
{
   var tmp_index=20*window.index;//20是服务端的信息长度

    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_data.php';
    $.post(ajaxUrl,{
        'index':tmp_index
    },function(data){
        var container =$('.page_content');
        if(data=='[]')
        {
            lehehe_alert('没有更多数据啦！小编会持续更新的！');

        }else{
            var list=JSON.parse(data);

            for(var i=0;i<list.length;i++)
            {
                var obj=list[i];
                var item=$('<div class="panel_list"></div>');
                var header=$('<table><tr><td width="20%"><img width="100" height="100" class="img-circle" src="'+obj['header']+'"></td> <td width="40%">'+obj['auth']+'</td> <td style="text-align: right" width="40%">'+obj['time']+'</td> </tr> </table>');
                var body=$('<div class="panel_body"></div>');
                if(obj['type']=='1')
                {
                    body.text(obj['content']);
                }else if(obj['type']=='2')
                {
                    body.append('<p>'+obj['append']+'</p>');
                    body.append('<img width="100%" src="'+obj['content']+'">');
                }
                var footer=$('<table> <tr> <td width="20%" onclick="user_up(this)" value="'+obj['id']+'" num="'+obj['up']+'"><img width="50" height="50" class="img-rounded" src="http://7xobr7.com1.z0.glb.clouddn.com/up.png" >'+obj['up']+'</td> <td width="20%" onclick="user_down(this)" value="'+obj['id']+'" num="'+obj['down']+'"><img width="50" height="50" class="img-rounded" src="http://7xobr7.com1.z0.glb.clouddn.com/down.png" >'+obj['down']+'</td> <td width="40%"></td> <td width="20%"><button id="'+obj['id']+'" onclick="switch_list('+obj['id']+')">展开评论</button></td> </tr> </table>');
                var tail=$('<div class="comment_panel '+obj['id']+'" > <div class="comment"> <table> <caption>贰友评论</caption> <tbody class="comment_list '+obj['id']+'"></tbody> </table> </div> <table> <tr> <td width="80%"> <input id="comment'+obj['id']+'"  placeholder="吐槽点什么？"> </td> <td > <button onclick="submit_comment('+obj['id']+')">评论</button></td> </tr> </table> </div>');
                tail.hide();
                item.append(header);
                item.append(body);
                item.append(footer);
                item.append(tail);
                container.append(item);
            }
            window.index++;
            //console.log(window.index);
            goods_display_block();
        }
    });

}

//请求评论数据
function get_comment(id)
{
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_comment.php';
    $.post(ajaxUrl,{
        'id':id
    },function(data){
        if(data=='none')
        {
            lehehe_alert('暂无评论哟！快来抢沙发！');
        }else{
            var list=JSON.parse(data);
            var panel=$('.comment_list.'+id);
            panel.html('');
            for(var i=0;i<list.length;i++)
            {
                var obj=list[i];
                panel.append('<tr><td>'+obj['u_name']+'：</td><td>'+obj['content']+'</td><td>'+(i+1)+'楼</td></tr>');
            }
        }
    });
}

//评论消息，并即时刷新到列表
function submit_comment(id)
{
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/add_comment.php';
    var text=$('#comment'+id).val();
    if(text.length<6)
    {
        lehehe_alert('亲！再给几个字吧！');
        return;
    }else{
        $.post(ajaxUrl,{
            'name':name,
            'text':text,
            'id':id
        },function(data){
            if(data=='ok')
            {
                var list=$('.comment_list.'+id);
                list.append('<tr><td>'+name+'：</td><td>'+text+'</td><td>Me</td></tr>');
                $('#comment'+id).val('');
                //switch_list(id);

            }else{
                lehehe_alert('哎呦！小贰也不知为嘛，评论失败了呢==');
            }
        })
    }
}

//提示信息
function lehehe_alert(mes)
{
    $('.lehehe_alert').text(mes);
    $('.lehehe_alert').fadeIn(800).delay(500).fadeOut(800);
}

//添加商品模块
function goods_display_block()
{
    var list_panel=$('.page_content');
    var item=$('<div class="panel_list"></div>');
    var header=$('<table></table>');
    var header_info=$('<tr style="text-align: left"><td>小贰推荐</td><td style="color: #ff4040">《每周精选》</td></tr>');
    var body=$('<div class="panel_body">dell超极本甩卖啦！<img width="100%" src="http://7xobr7.com1.z0.glb.clouddn.com/TB1MNw0JVXXXXXmXVXXXXXXXXXX_!!0-item_pic.jpg"></div>');
    var footer=$('<table><tr><td><del>原价：6000</del></td><td>贰货价：3600</td></tr></table>')
    header.append(header_info);
    item.append(header);
    item.append(body);
    item.append(footer);
    list_panel.append(item);
}

//添加小二叨逼叨活动
function daobidao_display_block()
{
    console.log('ok');
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_current_dbd.php';
    $.post(ajaxUrl,{
        'type':'index',
    },function(data){
        console.log('data');

        if(data=='')
        {
            console.log('false');

            return;
        }else {
            console.log('true');

            var obj=JSON.parse(data);
            var list_panel=$('.page_content');
            var item=$('<div class="panel_list" style="background-color: #ec8965"></div>');
            var header=$('<table></table>');
            var header_info=$('<tr style="text-align: center"><td width="20%"></td><td width="60%" style="color: #ff4040">《小贰叨逼叨》</td><td width="20%"></td></tr>');
            var body=$('<div class="panel_body">'+obj["des"]+'<img width="100%" src="'+obj["img"]+'"></div>');
            var footer=$('<table><tr><td>已经有'+obj["count"]+'位小伙伴参与啦</td><td  style="text-align: right"><button onclick="jump_comment_detail('+obj['id']+')">我要参与</button></td></tr></table>');
            header.append(header_info);
            item.append(header);
            item.append(body);
            item.append(footer);
            list_panel.prepend(item);
        }
    });

}

//跳转到评论列表
function jump_comment_detail(id)
{
    //alert(id);
    window.location.href='comment_details.html?id='+id;
}

//点赞
function user_up(dom)
{
    var id=$(dom).attr('value');
    var num=$(dom).attr('num');
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/up.php';
    $.post(ajaxUrl,{
        'id':id,
        'uid':window.user_id,
    },function(data){
        if(data=='ok')
        {
            lehehe_alert('投票成功！谢谢支持！');
            $(dom).html('<img width="50" height="50" class="img-rounded" src="http://7xobr7.com1.z0.glb.clouddn.com/up.png" >'+(parseInt(num)+1));

        }else if(data=='error')
        {
            lehehe_alert('投票失败！您是不是已经投过了呢？');
        }

    });

}
//点踩
function user_down(dom)
{
    var id=$(dom).attr('value');
    var num=$(dom).attr('num');
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/down.php';
    $.post(ajaxUrl,{
        'id':id,
        'uid':window.user_id,
    },function(data){
        if(data=='ok')
        {
            lehehe_alert('投票成功！小编会继续努力的！');
            $(dom).html('<img width="50" height="50" class="img-rounded" src="http://7xobr7.com1.z0.glb.clouddn.com/down.png" >'+(parseInt(num)+1));
        }else if(data=='error')
        {
            lehehe_alert('投票失败！您是不是已经投过了呢？');
        }
    });

}

//初始的时候执行，给全局变量赋值
function get_url_parma()
{
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/check_user.php';
    var   n=self.location.href.indexOf("?")//查看是否包含参数
    if(n>0)//存在参数
    {
        //参数
        var   para=self.location.href.substr(n+1);
        para=para.substr(4);
        window.user_id=para;//设置用户的id
        $.post(ajaxUrl,{
            'id':para
        },function(data){
            window.name=data;
        });
    }
}



//-------------------------------------叨逼叨----------------------------------------------
//参与评论
function say_something()
{
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/dbd_comment.php';
    var dbd_id=get_dbd_id();
    if(!dbd_id)
    {
        return;
    }
    var content=$('#text').val();
    if(content.length<5)
    {
        lehehe_alert('是不是太短了？在来点吧！');
        return;
    }else {
        $.post(ajaxUrl,{
            'content':content,
            'id':dbd_id
        },function(data){
            if(data=='error')
            {
                lehehe_alert('请登陆后再来参加活动！');
            }else if(data=='fail')
            {
                lehehe_alert('评论失败了呢，打死攻城狮好了_(:з」∠)_');
            }else if(data=='ok')
            {
                lehehe_alert('评论成功啦！说不定大奖就是你的哟！');
                location.href=self.location.href;
            }

        });
    }


}


//回复他人
function say_to_somebody(dom)
{
    var name=$(dom).attr('u_name');
    $('#text').val('对'+name+'说:');
}

//获得活动的id号
function get_dbd_id()
{
    var   n=self.location.href.indexOf("?")//查看是否包含参数
    if(n>0)//存在参数
    {
        return (self.location.href.substr(n+1)).substr(3);
    }else
    {
        lehehe_alert('没有指定的活动信息！');
        return false;
    }
}

//获得排行信息
function get_rank_data()
{
    var dbd_id=get_dbd_id();
    if(!dbd_id)
    {
        return;
    }
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_specific_dbd_comment.php';
    $.post(ajaxUrl,{
        'id':dbd_id,
        'index':0,
        'type':'rank'
    },function(data){
        if(data=='error')
        {
            lehehe_alert('暂时还没人有人参与哟！快来抢沙发啦！');
        }else {
            var list=JSON.parse(data);
            var container=$('.page_content');
            for(var i=0;i<list.length;i++)
            {
                //alert('dasda');
                var obj=list[i];
                var items=$('<div class="panel_list"> <table> <tr> <td width="20%"><img class="img-circle" width="50" height="50" src="'+obj['header']+'"></td> <td width="60%">'+obj['u_name']+'</td> <td style="text-align: right" width="20%">第'+(i+1)+'名</td> </tr> <tr> <td colspan="2" rowspan="2" > '+obj['content']+'</td> <td  style="text-align: right" cm_id="'+obj['id']+'" tmp_like="'+obj['up']+'" onclick="dbd_up(this)"><img width="50" height="50" src="http://7xobr7.com1.z0.glb.clouddn.com/u530.png">'+obj['up']+'</td> </tr> <tr> <td style="text-align: right"><button u_name="'+obj['u_name']+'" onclick="say_to_somebody(this)">回复</button></td> </tr> </table> </div>');
                //var items=$('<div class="panel_list">'+obj.toString()+'</div>');
                container.append(items);

            }
        }

    });

}

//获得评论列表
function get_dbd_comment_list()
{
    var dbd_id=get_dbd_id();
    if(!dbd_id)
    {
        return;
    }
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_specific_dbd_comment.php';
    $.post(ajaxUrl,{
        'id':dbd_id,
        'index':window.index,
        'type':'page'
    },function(data){
        if(data=='error')
        {
            lehehe_alert('没有数据了哟！');
        }else {
            var list=JSON.parse(data);
            var container=$('.page_content');
            if(window.index==0)
            {
                container.append('<div class="comment_title"><img width="50" height="50" src="http://7xobr7.com1.z0.glb.clouddn.com/top%2025.png"><span>评论列表</span></div>');
            }
            var num=list.length;
            for(var i=0;i<num;i++)
            {
                //alert('dasda');
                var obj=list[i];
                var items=$('<div class="panel_list"> <table> <tr> <td width="20%"><img class="img-circle" width="50" height="50" src="'+obj['header']+'"></td> <td width="60%">'+obj['u_name']+'</td> <td style="text-align: right" width="20%">'+(window.height)+'楼</td> </tr> <tr> <td colspan="2" rowspan="2" > '+obj['content']+'</td> <td  style="text-align: right" cm_id="'+obj['id']+'" tmp_like="'+obj['up']+'" onclick="dbd_up(this)"><img width="50" height="50" src="http://7xobr7.com1.z0.glb.clouddn.com/u530.png">'+obj['up']+'</td> </tr> <tr> <td style="text-align: right"><button u_name="'+obj['u_name']+'" onclick="say_to_somebody(this)">回复</button></td> </tr> </table> </div>');
                //var items=$('<div class="panel_list">'+obj.toString()+'</div>');
                container.append(items);
                window.height--;

            }
            window.index++;
        }

    });
}

//获得楼层数
function get_comment_num()
{
    var dbd_id=get_dbd_id();
    if(!dbd_id)
    {
        return;
    }
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/get_comment_num.php';
    $.post(ajaxUrl,{
        'id':dbd_id,
    },function(data){
        window.height=parseInt(data);
    });
}

//点赞
function dbd_up(dom)
{
    var ajaxUrl='http://am.erhuoapp.com/test/lehehe/dbd_up.php';
    var cm_id=$(dom).attr('cm_id');//评论的id
    var tmp_like=$(dom).attr('tmp_like');
    $.post(ajaxUrl,{
        'id':cm_id
    },function(data){
        if(data=='ok')
        {
            $(dom).html('<img width="50" height="50" src="http://7xobr7.com1.z0.glb.clouddn.com/u530.png">'+(parseInt(tmp_like)+1));
            lehehe_alert('支持+1');
        }else if(data=='error'){
            lehehe_alert('只有登陆用户才能参与哟！');
        }else if(data=='repeat')
        {
            lehehe_alert('您是不是已经支持过该评论了呢？');
        }

    });

}






