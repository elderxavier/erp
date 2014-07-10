<?php /* @var $links array */ ?>
<?php /* @var $default_action string*/ ?>

<div class="collapse navbar-collapse clearfix" id="main-menu">
    <ul class="nav navbar-nav">
        <?php foreach($links as $title => $params): ?>
            <?php if($params['visible'] == 1): ?>
            <li <?php if(Yii::app()->controller->id == $params['controller']):?> class="active" <?php endif; ?>>
                <a class="report" href="<?php echo Yii::app()->createUrl($params['controller'].'/'.$default_action) ?>">
                <span>
                    <img src="<?php echo '/images/'.$params['image']; ?>">
                </span>
                <span>
                    <?php echo Label::Get($title); ?>
                </span>
                </a>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div><!--/navbar-callapse -->