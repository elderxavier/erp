<?php /* @var $errors array */ ?>


<div class="row">

    <div class="form-holder col-xs-12">
        <div class="main-form-wrapper">
            <div class="login-header-holder"><h1><?php echo Label::Get('enter password'); ?></h1></div>

            <div class="form-wrapper">
                <form id="login-form" class="clearfix" method="post" action="<?php echo Yii::app()->createUrl('main/login'); ?>">

                    <div class="form-group">
                        <label for="login"><?php echo Label::Get('login'); ?></label>
                        <input type="text" name="username" id="login" class="form-control" />
                        <?php if(isset($errors['username'])): ?><div class="error"><?php echo Label::Get('user not found'); ?></div><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password"><?php echo Label::Get('password') ?></label>
                        <input type="password" name="password" id="password" class="form-control" />
                        <?php if(isset($errors['password'])): ?><div class="error"><?php echo Label::Get('wrong password'); ?></div><?php endif; ?>
                    </div>

                    <button class="btn btn-default pull-right"><span><?php echo Label::Get('login'); ?></span><span><img src="/images/filters_arrow.png" width="36" height="36" ></span></button>
                </form>
            </div><!--/form-wrapper -->
        </div><!--/form-holder -->
    </div>
</div><!--/row -->