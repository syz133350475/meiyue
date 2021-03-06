<!-- <header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>约会详情</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="find_date_detail">
        <div class="date_detail_place inner">
            <h3 class="title">
                <i class="itemsname color_y">
                    [<?= $date['user_skill']['skill']['name'] ?>]
                </i>
                <?= $date['title'] ?>
            </h3>
            <div class="place_pic">
							<span class="place">
								<img src="<?= generateImgUrl($date['user']['avatar']) ?>"/>
							</span>
                <div class="place_info">
                    <h3 class="userinfo">
                        <?= $date['user']['nick'] ?>
                        <span>
                            <?= getAge($date['user']['birthday']) ?>岁
                        </span>
                    </h3>
                    <h3 class="otherinfo">
                        <time class="color_gray">
                            <i class="iconfont">&#xe622;</i>
                            <?= getFormateDT($date['start_time'], $date['end_time']);?>
                        </time>
                        <address class="color_gray">
                            <i class="iconfont">&#xe623;</i>
                            <?= $date['site'] ?>
                        </address>
                    </h3>
                </div>
            </div>
        </div>
        <div class="date_des change-date-detail  mt20">
             <ul class="outerblock bgff">
                <li>
                    <h3 class="commontitle pd10">约会说明</h3>
                    <div class="con date_keyword">
                        <p><?= $date['description'] ?></p>
                    </div>
                </li>
                <li class="flex">
                     <?php if(count($date['tags']) > 0): ?><h3 class="">我的标签</h3>
                        <div class="con con_mark flex">
                            <?php foreach ($date['tags'] as $item): ?>
                                 <a class="mark"><?= $item['name'] ?></a>
                             <?php endforeach; ?>
                        </div>
                     <?php endif; ?>
                </li>
             </ul>
        </div>
       
        <div class="date_des mt20">
            <div class="con inner">
                <div class="date_time  flex flex_justify">
                    <span>我的钱包</span>
                    <div class="color_y"><?= isset($user)?$user['money']:'0' ?> 元</div>
                </div>
            </div>
        </div>
        <!--<p class="common commontitle inner mt20">
            <i class="iconfont">&#xe619;</i>报名即代表你已同意
            <a href="#this" class="color_y undertext">用户协议。</a>
        </p>-->
    </div>
</div>
<div style="height:1.4rem;"></div>
<div class="bottomblock">
    <?php if($date['status'] == 2): ?>
        <div class="flex flex_end">
            <span class="total">约会金：<i class="color_y"></i>
                <span class="color_y">
                    <i class="color_y lagernum"><?= getCost($date['start_time'], $date['end_time'], $date['price']); ?></i>元
                </span>
            </span>
            <a id="order_pay" class="nowpay">立即支付</a>
        </div>
    <?php else: ?>
        <a class="identify_footer_potion">已有赴约</a>
    <?php endif; ?>
</div>


<script>
    $.util.checkShare();
    $('.toback').on('click', function(){
        history.back();
    })

    LEMON.sys.setTopRight('分享');
    window.onTopRight = function () {
        shareBanner();
    };
    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/date-order/join/'.$date['id']; ?><?= isset($user)?'?ivc='.$user->invit_code:'';?>';
        /*window.shareConfig.title = '<?= $date['title'] ?>';*/
        /*var share_desc = '<?= isset($share)?$share['content']:''; ?>';*/
        window.shareConfig.title = '<?= $date['title'] ?>';
        window.shareConfig.imgUrl = '<?= getHost().$date['user']['avatar']; ?>';
        var share_desc = '约美食、约运动、约派对，拒绝平庸，活出态度';
        share_desc && (window.shareConfig.desc = share_desc);
        LEMON.show.shareBanner();
    }

    $('#order_pay').on('tap',function(){
        var dom = $(this);
        if(dom.hasClass('disabled')){
            return false;
        }
        dom.addClass('disabled');
        $.util.ajax({
            url: '/date-order/order-date/<?= $date->id; ?>',
            func:function(res){
                $.util.alert(res.msg);
                if(res.status){
                    window.location.href = res.redirect_url;
                }else{
                    if(res.errorStatus == 1) {
                        setTimeout(function() {
                            window.location.href='/purse/recharge?redurl=/date-order/join/<?= $date->id; ?>';
                    }, 1000);
                    } else {
                        dom.removeClass('disabled');
                    }
                }
            }
        });
    });
    LEMON.event.unrefresh();

</script>