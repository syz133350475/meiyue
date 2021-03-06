<div class="loginwraper"></div>
<div class="wraper loginpage">
    <div class="logo"><img src="/mobile/images/logo.png"/></div>
    <div class="loginbox">
        <div class="username">
            <i class="iconfont">&#xe608;</i>
            <input tabindex="1" type="number" id="phone" value="" placeholder="手机号" id="user" />
        </div>
        <div class="password validate">
            <i class="iconfont">&#xe607;</i>
            <input tabindex="2" type="text" id="vcode" placeholder="验证码" class="valicode" id="validate" />
            <a  id="gcode" class="fogetpwd getvalid disabled">获取验证码</a>
        </div>
        <div class="password">
            <i class="iconfont">&#xe606;</i>
            <input tabindex="3" type="password" id="pwd" placeholder="6-16位的密码" id="password" />
        </div>
        <div class="password">
            <i class="iconfont">&#xe69a;</i>
            <input type="text" placeholder="(选填)6位邀请码" id="incode" />
        </div>
        <a id="submit"  class="btn btn_bg_y mt100 disabled">注册</a>
         </div>
        
       <!--  <div class="login_box_btn">
            <div class="login_group mt80">
                <a href="/user/register?gender=1" class="btn btn_bg_t">我是用户</a>
                <a href="/user/register?gender=2" id="regW" class="btn btn_bg_active">申请入驻</a>
            </div>
        </div> -->
        <h4 class="getlogin"><a href="/user/login">已有账号，直接登录</a></h4>
    <div class="register_bottom_tips">
        <?php if($gender == 1): ?> 
            <a href="/index/agreement-user">注册表明已阅读并接受<i class='color_y'>“用户服务协议”</i></a>
        <?php else: ?>
            <a href="/index/agreement-artist">注册表明已阅读并接受<i class='color_y'>“艺人入驻协议”</i></a>
        <?php endif; ?>
    </div>
</div>
<?= $this->start('script') ?>
<script>
    $('#gcode').on('tap', function () {
        var obj = $(this);
        if (obj.hasClass('disabled')) {
            return false;
        }
        obj.addClass('disabled'); //加锁防止多次点击
        var phone = $('#phone').val();
        $.post('/user/sendVCode/1', {phone: phone}, function (res) {
            if (res.status === true) {
                var text = '<span id="timer">' + 30 + '</span>秒后重新发送';
                obj.html(text);
                t1 = setInterval(function () {
                    var timer = $('#timer').text();
                    timer--;
                    if (timer < 1) {
                        obj.html('获取验证码');
                        obj.removeClass('disabled');
                        clearInterval(t1);
                    } else {
                        $('#timer').text(timer);
                    }
                }, 1000);
            } else {
               if(res.code=='201'){
                   $.util.alert(res.msg);
                   setTimeout(function(){
                       $.util.lmlogin();
                   },1000);
               }
               
            }
        }, 'json');
    });

    $('#phone').on('keyup', function () {
        var obj = $(this);
        var phone = obj.val();
        var gcode = $('#gcode');
        if ($.util.isMobile(phone)) {
            gcode.removeClass('disabled');
        } else {
            if (!gcode.hasClass('disabled')) {
                gcode.addClass('disabled');
            }
        }
    });

    $('#phone,#pwd,#vcode').on('keyup', function () {
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var pwd = $('#pwd').val();
        var submit = $('#submit');
        if ($.util.isMobile(phone) && vcode && pwd) {
            submit.removeClass('disabled');
        } else {
            if (!submit.hasClass('disabled')) {
                submit.addClass('disabled');
            }
        }
    });
    $('#submit').on('tap', function () {
        var obj = $(this);
        var incode = $.util.getShareCode();
        if($('#incode').val()) {
            incode = $('#incode').val();
        }
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var pwd = $('#pwd').val();
        if (phone && vcode && pwd) {
            $.post('', {phone: phone, vcode: vcode, pwd: pwd, incode: incode}, function (res) {
                //$.util.alert(res.msg);
                if (res.status) {
                    obj.addClass('disabled');
                    if(res.is_login){
                        $.util.setCookie('token_uin',res.user.user_token);
                        LEMON.db.set('gender',res.user.gender);
                        LEMON.db.set('token_uin',res.user.user_token);
                        LEMON.db.set('im_accid',res.user.imaccid);
                        LEMON.db.set('im_token',res.user.imtoken);
                        LEMON.db.set('avatar',res.user.avatar);
                        LEMON.sys.endReg();
                    }
                    setTimeout(function () {
                        window.location.href = res.url;
                    }, 1000);
                } else {
                    $.util.alert(res.msg);
                    obj.removeClass('disabled');
                }
            }, 'json');
        }
    });
</script>
<?=
$this->end('script')?>