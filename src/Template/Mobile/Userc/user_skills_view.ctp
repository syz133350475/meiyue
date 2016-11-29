<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>
            <?= isset($userskill) ? '编辑技能' : '添加技能' ?>
        </h1>
        <span class="r_btn release-btn">发布</span>
    </div>
</header>
<div class="wraper">
    <form>
        <div class="edit_ability bgff">
            <ul class="outerblock">
                <li>
                    <div id="skill-btn" class="items flex flex_justify">
                        <div class='col-importent'>技能名称</div>
                        <div class="r_info">
                        <span id="show-skill-name">
                            <?= isset($userskill) ? $userskill['skill']['name'] : '请选择' ?>
                        </span>
                            <i class="iconfont rcon">&#xe605;</i>
                            <input id="skill-id-input" name="skill_id" type="text"
                                   value="<?= isset($userskill) ? $userskill['skill']['id'] : '' ?>" hidden/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items flex flex_justify" id="cost-btn">
                        <div class='col-importent'>技能价格</div>
                        <div class="r_info">
                            <span id="show-cost">
                                <?= (isset($userskill) && isset($userskill->cost))?$userskill->cost->money:0; ?>
                                <i class="smalldes">美币/小时</i>
                            </span>
                            <i class="iconfont rcon">&#xe605;</i>
                            <input
                                id="cost-id-input"
                                type="text"
                                name="cost_id"
                                value="<?= (isset($userskill) && isset($userskill->cost))?$userskill->cost->id:''; ?>"
                                hidden>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="edit_ability bgff mt40">
            <ul class="outerblock">
                <li>
                    <div id="choose_tags_btn" class="items flex flex_justify">
                        <div class='col-importent'>个人标签</div>
                        <div id="tag-container" class="r_info">
                            <?php if (!isset($userskill)): ?>
                                <i class="smalldes">4个以内</i>
                                <i class="iconfont rcon">&#xe605;</i>
                            <?php else: ?>
                                <?php foreach ($userskill['tags'] as $item): ?>
                                    [<a class="mark">
                                        <?= $item['name'] ?>
                                        <input type="text"
                                               name='tags[_ids][]'
                                               value="<?= $item['id'] ?>"
                                               tag-name="<?= $item['name'] ?>"
                                               hidden/>
                                    </a>]
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="edit_ability bgff inner mt40">
            <div class="date_text">
                <div class="b_title col-importent">约会说明</div>
                <div class="r_text">
                    <textarea name="description" placeholder="100个字以内"><?= empty($userskill['description'])?'':$userskill['description']; ?></textarea>
                </div>
            </div>
        </div>
        <div class="ability_items mt40">
            <div class="switchbox flex flex_justify inner">
                <div class="switch_str col-importent">上线</div>
                <div class="switch
                    <?= isset($userskill)?(($userskill['is_used'] ==1)?'on':'off'):'on' ?>">
                    <i class="swithbtn"></i>
                </div>
                <input id="use_status"
                       type="text"
                       name="is_used"
                       value="<?= isset($userskill) ? $userskill['is_used'] : 1 ?>"
                       hidden>
            </div>
        </div>
    </form>
</div>

<!--弹出层-->
<!--技能选择框-->
<?= $this->cell('Date::adminSkillsView'); ?>
<!--标签选择框-->
<?= $this->cell('Date::tagsView'); ?>
<!--价格选择框-->
<?= $this->cell('Date::costsView'); ?>

<script>

    $('.toback').on('click', function(){
        history.back();
    })

    $(".release-btn").on('click', function () {
        var url = '';
        if ('<?= isset($userskill)?'edit':'add' ?>' == 'add') {
            url = '/userc/user-skill-save/';
        } else {
            url = '/userc/user-skill-save/<?= $userskill['id']?>';
        }
        $.util.showPreloader();
        $.ajax({
            type: 'POST',
            url: url,
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                $.util.hidePreloader();
                if (typeof res === 'object') {
                    if (res.status) {
                        window.location.href = '/userc/user-skills-index';
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            },
            error: function(res) {
                $.util.hidePreloader();
            }
        });
    })


    //约会主题选择回调函数
    function chooseSkillCallBack(skill) {
        $("#skill-id-input").val(skill['id']);
        $("#show-skill-name").text(skill['name']);
    }


    $("#skill-btn").on('click', function () {
        new skillsPicker().show(chooseSkillCallBack);
    });


    //标签选择回调函数
    function chooseTagsCallBack(tagsData) {
        var html = "";
        for (key in tagsData) {
            var item = tagsData[key];
            html += "[<a class='mark'>" + item['name'] +
                "<input type='text' name='tags[_ids][]' value='" + item['id']
                + "' tag-name='" + item['name'] + "' hidden></a>]";
        }
        $("#tag-container").html(html);
    }

    $("#choose_tags_btn").on('click', function () {
        var currentDatas = [];
        $("#tag-container").find("input").each(function () {
            currentDatas.push($(this).val());
        })
        new TagsPicker().show(chooseTagsCallBack, currentDatas, 4);
    });


    $('.switch').on('click', function () {

        //判断此时开关显示状态
        if ($(".switch").hasClass('on')) {

            $(".switch").removeClass('on');
            $(".switch").addClass('off');
            $(".switch_str").text('下线');
            $("#use_status").val('0');

        } else {

            $(".switch").removeClass('off');
            $(".switch").addClass('on');
            $(".switch_str").text('上线');
            $("#use_status").val('1');

        }

    })


    function chooseCostCB(val) {
        $('#show-cost').text(val.cost + '/小时');
        $('#cost-id-input').val(val.cost_id);
    }
    var cPicker = new costsPicker();
    cPicker.init(chooseCostCB);
    $('#cost-btn').on('tap', function() {
        cPicker.show();
    });


    LEMON.sys.setTopRight('发布')
    window.onTopRight = function () {
        $(".release-btn").trigger('click');
    }


    LEMON.event.unrefresh();
</script>