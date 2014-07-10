<?php /* @var $this Controller */ ?>
<?php /* @var $links array */ ?>
<?php /* @var $params array */ ?>
<?php /* @var $separator string */ ?>

<?php $counter = 0; ?>
<?php foreach($links as $name => $link_params): ?>
    <?php if($link_params['visible'] == 1): ?>
        <?php $counter++; ?>
        <?php echo CHtml::link($this->labels[$name],Yii::app()->createUrl($link_params['controller'].'/'.$link_params['action'],$params),array('class' => $link_params['class'])); ?>
        <?php if($counter < count($links)): ?><?php echo $separator; ?><?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>