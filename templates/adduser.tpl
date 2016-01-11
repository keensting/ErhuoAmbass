<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <meta charset="UTF-8">
    <title>添加新的用户</title>
    <script type="text/javascript">
        $(function(){
            $('#datepicker').datetimepicker({
                //showOn: "button",
                //buttonImage: "./css/images/icon_calendar.gif",
                //buttonImageOnly: true,
//                showSecond: true,
                timeFormat: 'hh:mm:ss',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });
            $('.pro_city').ProvinceCity();//省市级联
            $('#randdata').click(function() {
               var code= code_generator();
                $(this).val(code);
                $('#pwd').val(hex_md5($('#pwd').val()));

            });
//            document.onkeypress = function(){
//                if(event.keyCode == 13) {
//                    alert('asdasd');
//                }}

        })
    </script>
</head>
<body>
<div class=" " id="state"></div>
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="Eadd_user_panel">
        <form id="form" method="post" action="./ajax/add_user.php" >
            <div class="form-group">
                <label>昵称</label>
                <input class="form-control" placeholder="请输入用户昵称" name="nickname" type="text">
            </div>
            <div class="form-group">
                <label>真实姓名</label>
                <input class="form-control" placeholder="请输入用户姓名" name="name" type="text">
            </div>
            <div class="form-group">
                <label>邀请码</label>
                <input class="form-control" placeholder="请输入用户的邀请码" name="key" type="text">
            </div>
            <div class="form-group">
                <label>密码</label>
                <input id="pwd" class="form-control" placeholder="请输入分配给用户的密码(明文,稍后会自动加密)" name="pwd">
            </div>
            <div class="form-group">
                <label>身份</label>
                <select name="auth" class="form-control">
                    {if $session['userinfo']['auth']==0}
                    <option value="0">管理员</option>
                    <option value="1">主管</option>
                    {/if}
                    <option value="2" selected>大使</option>
                </select>
            </div>
            <div class="form-group">
                <label>添加日期</label>
                <input id="datepicker" class="form-control" placeholder="请点击选择时间" name="date">
            </div>
            <div class="form-group">
                <label>填写学校</label>
                <input class="form-control" placeholder="请填写学校" name="school">
            </div>
            <div class="form-group">
                <label>选择地区</label>
                <div class="pro_city"></div>
            </div>
            <div class="form-group">
                <label>随机码</label>
                <input id="randdata" class="form-control" placeholder="点击自动生成，用于密码加密" name="randdata">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">提交</button>
                <button type="reset" class="btn btn-primary">重置</button>
            </div>


        </form>

    </div>



</div>


</body>
</html>