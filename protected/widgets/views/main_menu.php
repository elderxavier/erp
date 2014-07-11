<?php /* @var $links array */ ?>
<?php /* @var $default_action string*/ ?>
<?php /* @var $this MainMenu */ ?>
<?php /* @var $curr_controller */ ?>

<div class="collapse navbar-collapse clearfix" id="main-menu">
    <ul class="nav navbar-nav">
        <?php foreach($links as $title => $params): ?>
            <?php if($params['visible'] == 1): ?>
            <li <?php if($curr_controller == $params['controller']):?> class="active" <?php endif; ?>>
                <a class="report" href="<?php echo Yii::app()->createUrl($params['controller']); ?>">
                <span>
                    <img src="<?php echo '/images/'.$params['image']; ?>">
                </span>
                <span>
                    <?php echo $this->labels[$title]; ?>
                </span>
                </a>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div><!--/navbar-callapse -->