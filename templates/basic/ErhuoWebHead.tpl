

    <div class="Eheader">
        <div style="float: left;margin: 10px">
            <img src="http://7xngw8.com1.z0.glb.clouddn.com/app_icon.png" width="80" height="80" style="float: left">
        <h3 style="float: right;margin-top: 30px;"><strong style="color: #ff4040">贰货-</strong>大使后台</h3>--Test Version 2.4
            </div>
        <div class="Elogin_block">
            <div class="form-group">
                {if $header=='false'}
                <label class="btn btn-primary">登录</label>
                {*<label class="btn btn-primary">注册</label>*}
                {else}
                    <label class="Elogin_name">{$userinfo.name}</label>
                    <div  class="Elogin_out btn-group" >
                        <button class="btn btn-success" onclick="jump_home()"> 主页</button>
                        <button class="btn btn-success"   onclick="check_out()"> 注销</button>
                    </div>

                {/if}
            </div>
        </div>
    </div>

