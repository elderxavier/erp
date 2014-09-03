<?php /* @var $pages int */ ?>
<?php /* @var $current_page int */ ?>

<ul class="paginator">
    <?php for($i = 0; $i < $pages; $i++): ?>
        <li <?php if(($i+1) == $current_page): ?> class="current-page" <?php endif; ?>><?php echo ($i+1) ?></li>
    <?php endfor; ?>
</ul>
