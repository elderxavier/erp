<?php /* @var $avatar string */ ?>
<?php /* @var $name string */ ?>
<?php /* @var $surname string */ ?>
<?php /* @var $links */ ?>
<?php /* @var $this PersonalSettings */ ?>

<div class="login pull-right">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <span><?php echo $name.' '.$surname; ?></span> <img src="<?php echo $avatar; ?>" width="40" height="40">
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach($links as $link_name => $params): ?>
                <li>
                    <a class="<?php echo $params['class']; ?>" href="<?php echo Yii::app()->createUrl($params['controller'].'/'.$params['action']) ?>">
                        <span class="login-actions pull-left"><?php echo $this->labels[$link_name]; ?></span>
                        <span class="icon pull-right"></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div><!--/btn-group -->
</div><!--/login -->