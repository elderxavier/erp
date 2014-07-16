<?php /* @var $all_rights array */ ?>
<?php /* @var $current_rights array */ ?>
<?php /* @var $form_name string */ ?>

<?php foreach($all_rights as $block_name => $block_rights): ?>
    <fieldset>
        <legend><?php echo $block_name; ?></legend>
        <div class="form-group">
            <?php foreach($block_rights as $arr_settings): ?>
                <label class="checkbox-inline">
                    <input <?php if($current_rights[$arr_settings['right']]): ?>checked<?php endif; ?> type="checkbox" name="<?php echo $form_name;?>[rights][<?php echo $arr_settings['right']; ?>]"><?php echo $arr_settings['name']; ?>
                </label>
            <?php endforeach;?>
        </div><!--/form-group -->
    </fieldset>
<?php endforeach;?>