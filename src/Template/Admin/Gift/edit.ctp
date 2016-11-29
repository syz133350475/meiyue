<?php $this->start('static') ?>
    <link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
    <link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end() ?>
    <div class="work-copy">
        <?= $this->Form->create($gift, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
            <label class="col-md-2 control-label">名称</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('name', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">价格</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('price', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">图片</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('pic', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">说明</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('remark', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type='submit' id='submit' class='btn btn-primary' value='保存' data-loading='稍候...' />
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

<?php $this->start('script'); ?>
    <script type="text/javascript" src="/wpadmin/lib/jqform/jquery.form.js"></script>
    <script type="text/javascript" src="/wpadmin/lib/jqupload/jquery.uploadfile.js"></script>
    <script type="text/javascript" src="/wpadmin/lib/jqvalidation/js/languages/jquery.validationEngine-zh_CN.js"></script>
    <script type="text/javascript" src="/wpadmin/lib/jqvalidation/js/jquery.validationEngine.js"></script>
    <script>
        $(function () {
            $('form').validationEngine({focusFirstField: true, autoPositionUpdate: true, promptPosition: "bottomRight"});
            $('form').submit(function () {
                var form = $(this);
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (res) {
                        if (typeof res === 'object') {
                            if (res.status) {
                                layer.alert(res.msg, function () {
                                    window.location.href = '/gift/index';
                                });
                            } else {
                                layer.alert(res.msg, {icon: 5});
                            }
                        }
                    }
                });
                return false;
            });
        });
    </script>
<?php
$this->end();