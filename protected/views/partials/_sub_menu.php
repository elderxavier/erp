<?php /* @var $links array */ ?>
<?php /* @var $params array */ ?>
<?php /* @var $this Controller */ ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 " id="content-nav">
            <ul class="sub-menu clearfix">
                <?php foreach($links as $name => $link_array): ?>
                    <li>
                        <?php if($link_array['visible'] == 1): ?>
                        <a class="<?php echo $link_array['class']; ?>" href="<?php echo Yii::app()->createUrl($this->id.'/'.$link_array['action'],$params) ?>">
                            <span><?php echo $this->labels[$name]; ?></span>
                        </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- content-nav -->
    </div><!-- /row -->
</div><!--/container -->