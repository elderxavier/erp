<?php /* @var $links array */ ?>
<?php /* @var $params array */ ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 " id="content-nav">
            <ul class="sub-menu clearfix">
                <?php foreach($links as $name => $link_array): ?>
                    <li>
                        <?php if($link_array['visible'] == 1): ?>
                        <a class="<?php echo $link_array['class']; ?> <?php if(Yii::app()->controller->action->id == $link_array['action']): ?>active-sub-menu-a<?php endif; ?>" href="<?php echo Yii::app()->createUrl(Yii::app()->controller->id.'/'.$link_array['action'],$params) ?>">
                            <span><?php echo $name; ?></span>
                        </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- content-nav -->
    </div><!-- /row -->
</div><!--/container -->