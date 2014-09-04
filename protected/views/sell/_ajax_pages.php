<?php /* @var $pages int */ ?>
<?php /* @var $current int */ ?>
<?php /* @var $filters array */ ?>

<?php $str_data_filters = ""; ?>
<?php foreach($filters as $key => $value): ?>
    <?php $str_data_filters.='data-'.$key.'="'.$value.'" '; ?>
<?php endforeach; ?>

<ul class="paginator" <?php echo $str_data_filters; ?>>
    <?php for($i = 0; $i < $pages; $i++): ?>
        <li class="<?php if(($i+1) == $current): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
    <?php endfor; ?>
</ul>
