/**
 * Created by KeenSting on 2015/10/23.
 */
function reload_info(dom)
{
    var ajaxUrl=get_url_path()+'/project/htdocs/ajax/get_appoint_activity.php';
    var id=$(dom).val();
    $.post(ajaxUrl,{
        'id':id,
    },function(data){
        var json=JSON.parse(data);
        var url='http://7xnquu.com1.z0.glb.clouddn.com/';
        //banner图
        $('.page-header.text-center').find('img').attr('src',url+json.img);
        //活动名
        $('#name').text(json.name);
        //活动主题
        $('#theme').text(json.theme);
        //活动时间
        $('#time').text(json.time_begin+'-'+json.time_end);
        //活动内容
        $('#content').find('img').attr('src',url+json.content);
        //活动规则
        $('#rule').find('img').attr('src',url+json.rule);
    });
}