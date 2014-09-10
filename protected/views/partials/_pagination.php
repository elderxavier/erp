<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>

<div class="pages-holder">
    <ul class="paginator">
        <?php for($i = 0; $i < $pages; $i++): ?>
            <li class="<?php if(($i+1) == $current_page): ?>current-page<?php endif; ?> links-pages"><?php echo ($i+1) ?></li>
        <?php endfor; ?>
    </ul>
</div>