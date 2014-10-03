<?php /* @var $count int */ ?>
<?php /* @var $this ServicesController */ ?>

<?php if($count > 0): ?>
    <a href="<?php echo Yii::app()->createUrl('/services/list'); ?>">
        <span class="badge pull-right"><?php echo $count; ?></span>
        <span class="hidden-xs"><?php echo $this->labels['active tasks']; ?></span>
    </a>
<?php endif; ?>

