<!-- 添加约会主界面 -->
<div class="wraper page-current" id="page-Date">
    <!-- <header>
        <div class="header">
            <span class="l_btn cancel-btn" onclick="history.back();">取消</span>
            <span class="r_btn release-btn" date-id="<?= $date['id'] ?>">重新发布</span>
        </div>
    </header> -->
    <div class="edit_date_box">
        <form>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会主题</h3>
                        <div class="edit_r_con">
                            <input
                                id="show-skill-name"
                                type="text"
                                placeholder="请选择约会主题"
                                value="<?= $date['user_skill']['skill']['name'] ?>"
                                readonly="true"/>
                            <input
                                id="skill-id-input"
                                name="user_skill_id"
                                type="text"
                                value="<?= $date['user_skill']['id']; ?>"
                                hidden="true"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input id='title' type="text" name="title" value="<?= $date['title'] ?>"/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会时间</h3>
                        <div class="edit_r_con">
                            <input
                                id="time"
                                type="text"
                                value="<?= getFormateDT($date['start_time'], $date['end_time']) ?>"
                                readonly/>
                            <input
                                id="start-time"
                                type="text"
                                name="start_time"
                                value="<?= $date['start_time'] ?>"
                                hidden/>
                            <input
                                id="end-time"
                                type="text"
                                name="end_time"
                                value="<?= $date['end_time'] ?>"
                                hidden/>
                        </div>
                    </div>
                </li>
                <li onclick="location.hash = '#choosePlace'">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会地点</h3>
                        <div class="edit_r_con">
                            <input
                                id="thePlace"
                                name="site"
                                type="text"
                                readonly="true"
                                placeholder="选择约会地点"
                                value="<?= $date['site']; ?>"/>
                            <input
                                id="site_lat"
                                name="site_lat"
                                type="text"
                                value="<?= $date['site_lat']; ?>"
                                hidden/>
                            <input
                                id="site_lng"
                                name="site_lng"
                                type="text"
                                value="<?= $date['site_lng']; ?>"
                                hidden/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input
                                id="cost-btn"
                                type="text"
                                readonly="true"
                                placeholder="无需手动填写"
                                value="<?= $date['price']; ?>元/小时"/>
                            <input
                                id="cost-input"
                                name="price"
                                type="number"
                                readonly="true"
                                value="<?= $date['price']; ?>"
                                hidden/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40">
                <li>
                    <div class="edit_date_items flex flex_justify marks_edit">
                        <span class="edit_l_con">个人标签</span>
                        <div class="edit_r_con edit_r_marks" id="tag-container">
                            <?php if (!count($date['tags'])): ?>
                                <span class="color_light">请选择个人标签</span>
                            <?php else: ?>
                                <?php foreach ($date['tags'] as $item): ?>
                                    <a class="mark"><?= $item['name'] ?>
                                        <input
                                            type="text"
                                            name='tags[_ids][]'
                                            value="<?= $item['id'] ?>"
                                            tag-name="<?= $item['name'] ?>"
                                            hidden/>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="mt40 inner edit_date_desc">
                <h3 class="title">约会说明</h3>
                <div class="text_con">
                    <textarea id="description" name="description"
                              placeholder="可以简要介绍自己的特点，说说对约会的要求和期待。（100字以内）"><?= $date['description']; ?></textarea>
                </div>
            </div>
            <input type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input type="text" name="status" value="2" hidden>
        </form>
    </div>
    <div class="inner">
        <a class="btn btn_cancely mt60 mb60 delete-btn">删除</a>
    </div>
    <!--弹出层-->
    <!--技能选择框-->
    <?= $this->cell('Date::skillsView', ['user_id' => $user->id]); ?>
    <!--价格选择框-->
    <?= $this->cell('Date::costsView'); ?>
    <!--标签选择框-->
    <?= $this->cell('Date::tagsView'); ?>
    <!--日期时间选择器-->
    <?= $this->element('checkdate'); ?>
</div>

<!-- 地址列表 -->
<div class="wraper page" id="page-choosePlace" hidden>
    <div id="selfPlace" class='aPlace' hidden>
        <div class="place-self">
            <h3 class="basic_info_integrity">没有合适地点，<a href="javascript:toListplace();" class="color_y">回到搜索地址</a></h3>
            <div class="search_place_header inner">
                <div class="search-box flex flex_justify">
                    <div class="search-btn">
                        <input type="text" id="selfInput" value="" placeholder="请输入约会地点" results="5"/>
                    </div>
                    <span class="cancel-btn color_y" onclick='submitSelfPlace()'>提交</span>
                </div>

            </div>
        </div>
    </div>
    <div id="listPlace" class='aPlace'>
        <h3 class="basic_info_integrity">没有合适地点，<a href="javascript:toSelfplace();" class="color_y">手动输入地址</a></h3>
        <div class="search_place_header inner">
            <form action="">
                <div class="search-box flex flex_justify">
                    <div class="search-btn">
                        <i class="iconfont ico">&#xe689;</i><input id="searchInput" type="text" placeholder="请输入约会地点"
                                                                   results="5"/>
                    </div>
                    <span class="cancel-btn color_y" onclick='submitSearchPlace()'>搜索</span>
                </div>
            </form>
        </div>
        <div class="place_filter_tab" hidden>
            <div class="filter_tab_header flex">
                <span class="filter_tab_left">全部 <i class="iconfont">&#xe649;</i></span>
                <span class="filter_tab_right">默认排序 <i class="iconfont">&#xe649;</i></span>
            </div>
            <div class="filter_tab_content">
                <ul class="outerblock filter_tab_con tab_hide">
                    <li><a href="#this">龙华新区</a></li>
                    <li><a href="#this">龙华新区2</a></li>
                    <li><a href="#this">龙华新区3</a></li>
                </ul>
                <ul class="outerblock filter_tab_con" style="display: none;">
                    <li><a href="#this">综合</a></li>
                    <li><a href="#this">价格</a></li>
                    <li><a href="#this">智能</a></li>
                </ul>
            </div>
        </div>
        <div class="find_place_list" id="choosePlace">
            <ul id="place-list" class="outerblock"></ul>
        </div>
    </div>
</div>
<!-- 地址详情 -->
<div class="wraper fullscreen page" id="page-placeDetail" hidden>
    <iframe src="" width="100%" height="100%"></iframe>
    <div style="height:63px;"></div>
    <a id="go-here" href="#this" class="identify_footer_potion">就去这</a>
</div>


<script id="place-list-tpl" type="text/html">
    {{#places}}
    <li data-name="{{name}}" data-coordlng="{{location.lng}}" data-coordlat="{{location.lat}}" data-uid="{{uid}}"
        onclick="placeInfo(this)">
        <div class="items-block flex flex_justify">
            <div class="l_left flex  maxwid68" data-type='0' onclick="choosePlace(this)">
                <span class="radio-btn iconfont">&#xe635;</span>
                <h3 class="place-choose-text">
                    <div class="place_name">{{name}}</div>
                    <div class="color_gray place_address">{{address}}</div>
                    <div class="commend">
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i
                            class="color_y iconfont">&#xe62a;</i>
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_gray iconfont">&#xe62a;</i>
                    </div>
                </h3>
            </div>
            <div class="l_right aligncenter">
                <span class="con_price color_y">￥ <i class="lagernum">{{detail_info.price}}</i> /人</span>
                <a class="button btn_dark con_detail place_link" href="#placeDetail">查看详情</a>
            </div>
        </div>
    </li>
    {{/places}}
</script>
<script src="/mobile/js/mustache.min.js"></script>
<script>
    var skill_id = '<?= $date['user_skill']['id']; ?>';
    var curpage = 1;
    var query = '';
    var gurl = '/date-order/find-place/' + skill_id + "/";
    //约会主题选择回调函数
    function chooseSkillCallBack(userSkill) {
        $("#skill-id-input").val(userSkill['id']);
        $("#show-skill-name").val(userSkill['skill_name']);
        $('#cost-btn').val(userSkill['cost'] + " 元/小时");
        $('#cost-input').val(userSkill['cost']);
        skill_id = userSkill['skill_id'];
        gurl = '/date-order/find-place/' + skill_id + "/";
    }

    $("#show-skill-name").on('click', function () {
        new skillsPicker().show(chooseSkillCallBack);
    });


    //标签选择回调函数
    function chooseTagsCallBack(tagsData) {
        var html = "";
        for (key in tagsData) {
            var item = tagsData[key];
            html += "<a class='mark'>" + item['name'] +
                "<input type='text' name='tags[_ids][]' value='" + item['id']
                + "' tag-name='" + item['name'] + "' hidden></a>";
        }
        $("#tag-container").html(html);
    }

    $("#tag-container").on('click', function () {
        var currentDatas = [];
        $("#tag-container").find("input").each(function () {
            currentDatas.push($(this).val());
        })
        new TagsPicker().show(chooseTagsCallBack, currentDatas);
    });


    //日期选择回调函数
    function choosedateCallBack(start_datetime, end_datetime) {
        var start_datetime = start_datetime.replace(/\//g, '-');
        var end_datetime = end_datetime.replace(/\//g, '-');
        var time_tmpstart = (start_datetime).split(" ");
        var time_tmpend = (end_datetime).split(" ");
        var year_month_date = time_tmpstart[0];
        var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
        var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
        $("#time").val(year_month_date + " " + start_hour_second + "~" + end_hour_second);
        $("#start-time").val(start_datetime);
        $("#end-time").val(end_datetime);
    }


    var dPicker = new mydateTimePicker();
    dPicker.init(choosedateCallBack);
    $("#time").on('click', function () {
        dPicker.show();
    });


    $(".release-btn").on('click', function () {
        release();
    })

    function release() {
        //验证开始日期
        var start_time = new Date($("#start-time").val());
        var current_time = new Date();
        if (Date.parse(start_time) < Date.parse(current_time)) {
            $.util.alert("约会时间不能早于当前时间!");
            return;
        }
        $date_time = $("#time").val();
        $skill = $("#skill-id-input").val();
        $title = $("#title").val();
        $place = $("#thePlace").val();
        $cost = $("#cost-input").val();
        $desc = $("#description").val();
        $tag = $("#tag-container").find('input').length;
        if (!$skill) {
            $.util.alert('请选择约会主题');
            return;
        }
        if (!$title) {
            $.util.alert('请填写约会标题');
            return;
        }
        if (!$date_time) {
            $.util.alert("请选择约会时间!");
            return;
        }
        if (!$place) {
            $.util.alert('请选择约会地点');
            return;
        }
        if (!$cost) {
            $.util.alert('请选择约会价格');
            return;
        }
        if (!$tag) {
            $.util.alert('请选择个人标签');
            return;
        }
        if (!$desc) {
            $.util.alert('请输入约会说明');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/date/edit/<?= $date['id'] ?>',
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {
                        $.util.alert(res.msg);
                        window.location.href = '/date/index';
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });
    }
    $(".delete-btn").on('click', function () {

        if (confirm("确定删除?")) {
            $.ajax({
                type: 'POST',
                url: '/date/delete/' + <?= $date['id'] ?>,
                dataType: 'json',
                success: function (res) {
                    if (typeof res === 'object') {
                        $.util.alert(res.msg);
                        setTimeout(function () {
                            if (res.status) {
                                window.location.href = '/date/index';
                            }
                        }, 1000)
                    }
                }
            });
        }

    });


    var place_name, coord_lng, coord_lat;
    $(document).on('tap', '.place_link', function () {
        //点击查看详情页
        $.util.showPreloader('加载中...');
        var uid = $(this).data('uid');
        $('#go-here').data('name', $(this).data('name'));
        $('#go-here').data('coordlng', $(this).data('coordlng'));
        $('#go-here').data('coordlat', $(this).data('coordlat'));
        setTimeout(function () {
            location.hash = '#placeDetail';
            $.util.hidePreloader();
        }, 300);

        $('#page-placeDetail').find('iframe').remove();
        $('#page-placeDetail').prepend('<iframe width="100%" height="100%"></iframe>');
        $('#page-placeDetail').find('iframe').attr('src', 'http://map.baidu.com/mobile/webapp/search/search/qt=inf&uid=' + uid + '/?third_party=uri_api');
    });



    function submitSearchPlace() {
        curpage = 1;
        var searchKey = $('#searchInput').val();
        if (!searchKey) {
            $.util.alert('请输入地址');
            return;
        }
        query = '?tag=' + searchKey;
        $.util.asyLoadData({
            gurl: gurl, page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'
            , query: query
        });
    }
    $(window).on('hashchange', function () {
        //页面切换
        if (location.hash == '#choosePlace') {
            if (!skill_id) {
                $.util.alert('请先选择约会主题');
                location.hash = '#this';
                return;
            }
            curpage = 1;
            loadHashPage();
            $.util.asyLoadData({gurl: gurl, page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'});
            setTimeout(function () {
                $(window).on("scroll", function () {
                    $.util.listScroll('place-list', function () {
                        //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                        $.util.asyLoadData({
                            gurl: gurl, page: curpage,
                            tpl: '#place-list-tpl', id: '#place-list', more: true, key: 'places'
                        });
                    })
                });
            }, 2000)
        } else {
            if (location.hash == '#placeDetail') {
                setTimeout(function () {
                    loadHashPage();
                }, 1000);
            } else {
                loadHashPage();
            }
        }
    });
    function loadHashPage() {
        var hash = location.hash;
        var page = '#page-' + hash.substr(1);
        if ($(page).length) {
            $('div[id^="page-"]').hide();
            $(page).show();
        } else {
            $('div[id^="page-"]').hide();
            $('.page-current').show();
        }
    }
    function placeInfo(em) {
        //点击查看详情页
        place_uid = $(em).data('uid');
        place_name = $(em).data('name');
        coord_lng = $(em).data('coordlng');
        coord_lat = $(em).data('coordlat');
        console.log($(em));
    }

    function choosePlace(em) {
        $(em).addClass('choose');
        setTimeout(function () {
            $('#thePlace').val(place_name);
            location.hash = '';
        }, 300);
    }

    function toListplace() {
        $('#listPlace').show();
        $('#selfPlace').hide();
    }
    function submitSelfPlace() {
        if ($('#selfInput').val() == '') {
            $.util.alert('请输入地址');
            return;
        }
        $('#thePlace').val($('#selfInput').val());
        place_name = $('#selfInput').val();
        location.hash = '';
    }
    function toSelfplace() {
        $('#selfPlace').show();
        $('#listPlace').hide();
    }

    $('#go-here').on('tap', function () {
        //选择好地址
        place_name = $(this).data('name');
        coord_lng = $(this).data('coordlng');
        coord_lat = $(this).data('coordlat');
        $('#thePlace').val(place_name);
        $('#site_lat').val(coord_lat);
        $('#site_lng').val(coord_lng);
        location.hash = '';
    });

    LEMON.event.unrefresh();
    LEMON.sys.back('/date/index');
    LEMON.sys.setTopRight('重新发布')
    window.onTopRight = function () {
        release();
    }
</script>