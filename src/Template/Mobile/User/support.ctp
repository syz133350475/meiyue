<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>支持我的人</h1>
    </div>
</header> -->
<div class="wraper">
    <ul class="praised_list mt20 bgff">
        <?php
        if ($supports): ?>
            <?php foreach ($supports as $item): ?>
                <li onclick="location.href='/user/male-homepage/<?= $item['supporter']['id']; ?>'">
                    <div class="praised_block">
                        <div class="praised_list_left support">
                        <span class="avatar">
                            <img src="<?= generateImgUrl($item['supporter']['avatar']); ?>" alt=""/>
                        </span>
                            <h3>
                                <div class="username"> <?= $item['supporter']['nick'];; ?><span class="age"><i
                                                class="iconfont color_y">&#xe61c;</i> <?= $item['supporter']['birthday']; ?>
                                        岁</span></div>
                                <div class="beauty_num">魅力值： <i class="color_friends">
                                        <?= $item['supporter']['recharge'];; ?>
                                    </i></div>
                            </h3>
                        </div>
                        <div class="praised_list_right">
                        <span class="support_num">
                            已支持:  
                            <i class="color_friends">
                                <?= $item['spcount']; ?>
                            </i>
                            次
                        </span>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>