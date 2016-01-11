<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <meta charset="UTF-8">
    <title>貮货-大使后台</title>
    <script type="text/javascript">
        $(function(){
            $('#state').hide();
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
<div class="Epanel">
    <div class="panel-body">
        <form><br>
            <div class="form-group">
                <label>账户</label>
                <input id="name" class="form-control" placeholder="请输入账户或邀请码">
            </div>
            <br>
            <div class="form-group">
                <label>密码</label>
                <input id="pwd" class="form-control" placeholder="输入您的密码" type="password">
            </div><br>
            <div class="form-group">
                <label class="btn btn-success col-lg-12" onclick="login_check()">登录</label>
                {*<label class="btn btn-primary" aria-disabled="true">注册</label>*}

            </div>


        </form>
    </div>


</div>
</div>


</body>
</html>