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
        //bannerͼ
        $('.page-header.text-center').find('img').attr('src',url+json.img);
        //���
        $('#name').text(json.name);
        //�����
        $('#theme').text(json.theme);
        //�ʱ��
        $('#time').text(json.time_begin+'-'+json.time_end);
        //�����
        $('#content').find('img').attr('src',url+json.content);
        //�����
        $('#rule').find('img').attr('src',url+json.rule);
    });
}