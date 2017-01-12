<div class="wraper pd45">
    <div class="activity_list">
        <div class="date_list">
            <div class="date_list_header changwid" id="imgTab">
                <div id="tab-2" class="todate"><span class="headertab">派对</span></div>
                <div id="tab-3" class="todate"><span class="headertab">选美</span></div>
            </div>
        </div>
        <div class="activity_list_con" id='imgBox'>
            <!--派对-->
            <section>
                <!--轮播图-->
                <!--<div id="party-coverimg" class="abanner">
                    &nbsp;
                </div>-->
                <div id="party_list" class="party_content">
                    <!-- 派对列表 -->
                    &nbsp;
                </div>
            </section>
            <!--头牌-->
            <section>
                <div class="abanner">
                    <ul class="tou-imglist" id="oBox">
                        <?php foreach($carousels as $carousel): ?>
                            <li><a href="/activity/carousel-page/<?= $carousel->id; ?>"><img src="<?= createImg($carousel->url); ?>"/></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if(count($carousels) > 1): ?>
                    <div class="yd flex flex_center" id="oTab">
                        <?php foreach($carousels as $key => $$carousel): ?>
                            <span class="<?= ($key == 0)?'cur':'';?>"></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if(isset($user) && $user->gender == 2): ?>
                    <div class="invite">
                        <a href="/user/share" class="btn btn_t_border">邀请好友支持我</a>
                    </div>
                <?php else: ?>
                <?php endif; ?>
                <div class="rank_list">
                    <ul class="rank_header">
                        <li class="top-tab" act="top_1"><span>周榜</span></li>
                        <li class="top-tab" act="top_2"><span>月榜</span></li>
                        <li class="top-tab" act="top_3"><span>土豪榜</span></li>
                    </ul>
                    <div class="rank_con">
                        <ul class="outerblock voted_list bgff" id="my-top">
                            <!-- 我的头牌 -->
                        </ul>
                        <ul class="outerblock voted_list bgff set-voted-wid" id="top-list">
                            <!-- 头牌列表 -->
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div style='height:57px;'></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'activity']) ?>

<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="activity-list-tpl" type="text/html">
    {{#datas}}
    <div class="items" data-id="{{id}}" onclick="toActView({{id}})">
        <div class="items_pic">
            <img src="{{big_img}}"/>
        </div>
        <div class="items_con flex flex_justify">
            <h3 class="items_title">{{title}}</h3>
            <div class="items_time">
                 <div class="button {{^isend}}btn_dark{{/isend}}{{#isend}}btn_light{{/isend}}" {{^isend}}onclick="joinAct({{id}})"{{/isend}}">
                  {{^isend}}我要报名{{/isend}}{{#isend}}报名结束{{/isend}}
                 </div>
            </div>
        </div>
        <div class="items_adress flex flex_justify">
            <div><i class="iconfont ico">&#xe623;</i>{{site}}</div>
           
            <div>
                <i class="iconfont ico">&#xe64b;</i>{{time}}
            </div>
        </div>
    </div>
    {{/datas}}
</script>

<script id="top-list-tpl" type="text/html">
    {{#datas}}
    <li class="flex flex_justify">
        <div class="flex">
            <span class="place {{#top3}}silver{{/top3}}">{{index}}</span>
            <div class="place_info">
            <span class="avatar" onclick="location.href='/user/my-homepage/{{user.id}}'">
                <img src="{{user.avatar}}">
            </span>
                <h3>
                <span class="place_name"><i class="name">{{user.nick}}</i><!-- <i class="vip">VIP 5</i><i
                        class="cup"><img src="/mobile/images/cup.jpg"/></i>--></span>
                <span class="place_number color_gray"><em class="color_y"><i
                            class="iconfont color_y">&#xe61d;</i> {{user.age}}</em>
                            本周魅力值：<i class="color_y max-num">{{total}}</i>
                        </span>
                </h3>
            </div>
        </div>
        {{#ismale}}
    <span class="button btn_dark suport-btn" onclick="window.location.href='/gift/index/{{user.id}}';event.stopPropagation(); ">
        支持她
    </span>
        {{/ismale}}
    </li>
    {{#ishead}}<div style="height:20px;background:#f4f4f4"></div>{{/ishead}}
    {{/datas}}
</script>


<script id="mytop-list-tpl" type="text/html">
    {{#mydata}}
    <li class="flex flex_justify">
        <div class="flex">
            <span class="place silver">{{index}}</span>
            <div class="place_info">
            <span class="avatar" onclick="location.href='/user/my-homepage/{{user.id}}'">
                <img src="{{user.avatar}}">
            </span>
                <h3>
                <span class="place_name"><i class="name">{{user.nick}}</i><!-- <i class="vip">VIP 5</i><i
                        class="cup"><img src="/mobile/images/cup.jpg"/></i>--></span>
                <span class="place_number color_gray"><em class="color_y"><i
                            class="iconfont color_y">&#xe61d;</i> {{user.age}}</em>
                            本周魅力值：<i class="color_y max-num">{{total}}</i>
                        </span>
                </h3>
            </div>
        </div>
        {{#ismale}}
    <span class="button btn_dark suport-btn" onclick="window.location.href='/gift/index/{{user.id}}';event.stopPropagation(); ">
        支持她
    </span>
        {{/ismale}}
    </li>
    {{/mydata}}
</script>


<script id="rich-list-tpl" type="text/html">
    {{#datas}}
    <li class='ul-con'>
        <div class="voted_con flex flex_justify">
            <div class="flex" onclick="window.location.href='/user/male-homepage/{{id}}'">
                <span class="voted_place {{#top3}}silver{{/top3}}">{{index}}</span>
                <div class="voted_place_info">
                    <span class="avatar">
                        <img src="{{avatar}}"/>
                    </span>
                    <h3>
                        <div class='flex'><span class="voted_name">{{nick}}</span><span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>{{#upackname}}<span class="highter-vip">{{upackname}}</span>{{/upackname}}</div>
                        <span class="voted_number color_gray">已消费：{{consumed}}美币</span>
                    </h3>
                </div>
            </div>
            <div>
                <div data-id="{{id}}" class="likeIt alignright"><i class='iconfont commico {{#followed}}activeico{{/followed}}'></i></div>
                <div class="alignright"><i class='lagernum color_active'>{{recharge}}</i></div>
            </div>
        </div>
    </li>
    {{/datas}}
</script>

<script id="nodata-tpl" type="text/html">
    <div class="empty_container">
        <div class="empty-content  mt{{top}}">
            <i class="iconfont empty-ico">&#{{icon}}</i>
            <p class="empty-tips">{{text}}</p>
        </div>
    </div>
</script>

<?php $this->end('static') ?>

<script src="/mobile/js/loopScroll.js" type="text/javascript" charset="utf-8"></script>
<script>
    var activity = function (o) {
        this.opt = {
            tab_activity: 1,
            tab_top: 2,
            cur_tab: 1,  //记录当前显示的tab
            tabInitLoad: [0, 1, 1], //第一次加载
            tabPage: [1, 1, 1], //当前第几页
            tabLoadEnd: [0, 0, 0, 0], //页码加载结束
            tabLoadHold: [0, 0, 0, 0], //页码加载结束
            tabDataTpl: [
                '',
                '#activity-list-tpl',
                '#top-list-tpl'
            ],
            listId: [
                '',
                '#party_list',
                '#winer_list'
            ],
            tabDataUrl: [
                '',
                '/activity/get-all-datas-in-page/',
                '/activity/get-top-list/'
            ],
            top_obj: null
        }
        $.extend(this, this.opt, o);
    }

    $.extend(activity.prototype, {
        init: function () {
            var curtr = "<?= isset($curtab)?$curtab:'date'; ?>";
            if(curtr == 'party') {
                this.cur_tab = 1;
            } else if(curtr == 'top') {
                this.cur_tab = 2;
            }
            if(/#1|#2/.test(location.hash)) {
                this.cur_tab = location.hash.replace('#', '');
            }
            this.tabEvent();
            this.scroll();
        },
        tabEvent: function () {
            var obj = this;
            $.util.loop({
                tp: 'text', //图片img或是文字text
                loadImg: true,
                isInit: true,
                moveDom: $('#imgBox'),
                moveChild: $('#imgBox section'),
                tab: $('#imgTab div'),
                loopScroll: false,
                autoTime: 0,
                lockScrY: true,
                //imgInitLazy: 1000,
                index: obj.cur_tab,
                viewDom: $('.activity_list'),
                fun: function (index) {
                    location.hash = '#'+index;
                    index = parseInt(index);
                    //判断是否是在当前页，禁止本页触发tab切换事件
                    if (obj.cur_tab == index && !this.isInit) {
                        return;
                    }
                    //更新cur_tab
                    obj.cur_tab = index;
                    window.scrollTo(0, 0);
                    this.isInit = false;
                    obj.tabInit(index);
                }
            });
        },
        tabInit: function (index) {
            if (!this.tabInitLoad[index]) return;
            //首次加载数据
            if(index != this.tab_top) {
                this.asyLoadData(this.cur_tab);
            } else {
                if (!this.top_obj) {
                    this.top_obj = new topPage();
                    this.top_obj.init();
                }
            }
        },
        scroll: function () {
            var obj = this;
            $(window).on("scroll", function () {
                if (obj.tabInitLoad[obj.cur_tab]) return;
                var st = document.body.scrollTop;
                var cbodyH = $(obj.listId[obj.cur_tab]).height() - 600;
                if (st >= cbodyH && obj.cur_tab != 3 && !obj.tabLoadHold[obj.cur_tab] && !obj.tabLoadEnd[obj.cur_tab]) {
                    obj.asyLoadData(obj.cur_tab);
                }
            });
        },

        asyLoadData: function (curtab) {
            this.tabLoadHold[curtab] = 1;   //防止连刷
            $.util.showPreloader();
            var template = $(this.tabDataTpl[curtab]).html();
            var nodataTmpl = $('#nodata-tpl').html();
            var url = this.tabDataUrl[curtab] + this.tabPage[curtab];
            Mustache.parse(template);   // optional, speeds up future uses
            Mustache.parse(nodataTmpl);   // optional, speeds up future uses
            var obj = this;
            $.getJSON(url, function (data) {
                $.util.hidePreloader();
                if (data.code === 200) {
                    var rendered = Mustache.render(template, data);
                    var nodataRend = '';
                    obj.tabPage[curtab]++;

                    switch (curtab) {
                        case obj.tab_date:
                            if (obj.tabInitLoad[curtab]) {
                                nodataRend = Mustache.render(
                                    nodataTmpl,
                                    {'text':'约会即将发布，敬请期待哟~', 'icon':'xe60f;', 'top':'350'}
                                );
                            }
                            break;
                        case obj.tab_activity:
                            if (obj.tabInitLoad[curtab]) {
                                nodataRend = Mustache.render(
                                    nodataTmpl,
                                    {'text':'选美即将上线，敬请期待哟~', 'icon':'xe645;', 'top':'80'}
                                );
                                /*if(data.carousel) {
                                 $('#party-coverimg')
                                 .html("<a href='"+data.carousel.to_url+"'><img src='"+data.carousel.url+"'/></a>");
                                 }*/
                            }
                            break;
                        case obj.tab_top:
                            if (obj.tabInitLoad[curtab]) {
                            }
                            break;
                    }

                    if(obj.tabInitLoad[curtab]) {
                        if((data.datas).length == 0) {
                            rendered = nodataRend;
                        }
                        $(obj.listId[curtab]).html(rendered);
                        obj.tabInitLoad[curtab] = 0;
                    } else {
                        if((data.datas).length == 0) {
                            if(obj.tabLoadEnd[curtab] && obj.tabLoadHold[curtab]) return;
                            obj.tabLoadEnd[curtab] = 1;
                            $(obj.listId[curtab]).append('<p class="smallarea aligncenter mt20">没有更多数据了</p>');
                            return;
                        }
                        $(obj.listId[curtab]).append(rendered);
                    }
                }
                obj.tabLoadHold[curtab] = 0;
            });
        },
    });


    var topPage = function (o) {
        this.opt = {
            week_tab: 1,
            month_tab: 2,
            rich_tab: 3,
            cur_tab: <?= $top_tab; ?>,
            tabDataTpl: ['', '#top-list-tpl', '#top-list-tpl', '#rich-list-tpl'],
            tab_action: [
                '',
                '/activity/get-top-list/week',
                '/activity/get-top-list/month',
                '/activity/get-rich-list'
            ],   //请求url
            container_id: '#top-list',
        };
        $.extend(this, this.opt, o);
    };

    $.extend(topPage.prototype, {
        init: function () {
            var obj = this;
            $('.top-tab').each(function() {
                if($(this).attr('act') == ('top_'+obj.cur_tab)) {
                    $(this).addClass('current');
                }
            });
            this.addTabEvent();
            this.loadDataWithoutPage(this.tab_action[this.cur_tab], 'top_week');
        },
        addTabEvent: function () {
            var obj = this;
            $(".top-tab").on('click', function () {
                $(".top-tab").each(function () {
                    $(this).removeClass('current');
                });
                $(this).addClass('current');
                if ($(this).attr('act') == 'top_1') {
                    obj.cur_tab = obj.week_tab;
                    obj.loadDataWithoutPage(obj.tab_action[obj.cur_tab], 'top_week');
                } else if ($(this).attr('act') == 'top_2') {
                    obj.cur_tab = obj.month_tab;
                    obj.loadDataWithoutPage(obj.tab_action[obj.cur_tab], 'top_month');
                } else if ($(this).attr('act') == 'top_3') {
                    obj.cur_tab = obj.rich_tab;
                    obj.loadDataWithoutPage(obj.tab_action[obj.cur_tab], 'rich_list');
                }

            });
        },
        loadDataWithoutPage: function (action, tab) {
            var obj = this;
            var template = $(this.tabDataTpl[this.cur_tab]).html();
            Mustache.parse(template);   // optional, speeds up future uses
            $.util.showPreloader('加载中...');
            $.ajax({
                url: action,
                type: "POST",
                dataType: "json",
                success: function (res) {
                    $.util.hidePreloader();
                    if (res.status) {
                        if(('top_week' == tab || 'top_month' == tab) && res.mydata) {
                            if(res.mydata) {
                                $('#my-top').show();
                                var mytemp = $('#mytop-list-tpl').html();
                                var myrend = Mustache.render(mytemp, res);
                                $('#my-top').html(myrend);
                            }
                            var rendered = Mustache.render(template, res);
                            $(obj.container_id).html(rendered);
                            return;
                        }
                        $('#my-top').hide();
                        var rendered = Mustache.render(template, res);
                        $(obj.container_id).html(rendered);
                    }
                }
            });
        }
    });


    var activityobj = new activity();
    activityobj.init();

    $(document).on('tap', '.likeIt', function () {
        var user_id = $(this).data('id');
        var $obj = $(this);
        followIt(user_id,$obj);
    });
    function followIt(id, $obj) {
        $.util.ajax({
            url: '/user/follow',
            data: {id: id},
            func: function (res) {
                var msg = (res.msg).replace('关注', '点赞');
                $.util.alert(msg);
                if(res.status) {
                    $obj.find('i').toggleClass('activeico');
                }
            }
        })
    }

    /*$(document).on('tap', '.act-item', function() {
     var actid = $(this).data('id');

     });*/
    function toActView(actid) {
        window.location.href='/activity/view/' + actid;
    }

    function joinAct($actid) {
        event.stopPropagation();
        $.util.checkLogin('/activity/pay-view/' + $actid);
    }
    /*$(document).on('click', '.join-act', function(event) {
         event.stopPropagation();
         $actid = $(this).data('id');
         $.util.checkLogin('/activity/pay-view/' + $actid);
    });*/


    //头牌轮播图
    $.util.loop({
        tp: 'img', //图片img或是文字text
        loadImg: true,
        moveDom: $('#oBox'), // eg: $('#loopImgUl')
        moveChild: $('#oBox li'), //$('#loopImgUl li')
        tab: $('#oTab span'), //$('#loopImgBar li')
        loopScroll: true,
        touchEvent:false,
        autoTime: 3000,
        lockScrY: true,
        //imgInitLazy: 1000,
        index: 1,
        viewDom: $('.abanner'),
        fun: function (index) {

        }
    });
</script>