<!DOCTYPE html>
<html lang="en">
<head>
    {include file="./basic/css&js.tpl"}
    <link type="text/css" rel="stylesheet" href="../style/manager.css">
    <script type="text/javascript" src="../js/manager.js"></script>
    <meta charset="UTF-8">
    <title>活动管理</title>
    <script type="text/javascript">
        $(function(){
            $('.loading').hide();
        })
    </script>
</head>
<body>
{include file="./basic/loading.tpl"}
<div class="container">
    <!--header-->
    {include file="./basic/ErhuoWebHead.tpl"}
    <!--body-->
    <div class="panel panel-default" style="margin-top: 100px">
        <div class="panel-heading">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" id="selector" data-toggle="dropdown">
                    选择展示类型&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-describedby="selector">
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        <a role="menuitem" onclick="change_list_type(this,'all')">全部活动</a>
                    </li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        <a role="menuitem" onclick="change_list_type(this,'online')">上线活动</a>
                    </li>
                    <li role="presentation" class="divider"></li>

                    <li role="presentation">
                        <a role="menuitem" onclick="change_list_type(this,'amb')">开放大使提交的活动</a>
                    </li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        <a role="menuitem" onclick="change_list_type(this,'offline')">未上线活动</a>
                    </li>
                    <li role="presentation" class="divider"></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <caption id="type" style="font-size: 30px;color: #ff4040"></caption>
                <thead id="head">

                </thead>
                <tbody id="body">

                </tbody>


            </table>

        </div>

    </div>



</div>


</body>
</html>