<?php /* @var $this ProductsController */ ?>
<?php /* @var $recipients Clients[] */ ?>
<?php /* @var $files ProductFiles[] */ ?>
<?php /* @var $text string */ ?>

<div class="address-holder">
    <h5><?php echo $this->labels['recipients']; ?></h5>
    <ul class="clearfix">
        <?php foreach($recipients as $nr => $recipient): ?>
            <li><?php echo $recipient->getFullName(); ?> (<?php echo $recipient->email1; ?>)</li>
            <input type="hidden" name="recipients[<?php echo $nr ?>]" value="<?php echo $recipient->id; ?>">
        <?php endforeach; ?>
    </ul>
</div><!--/address-holder -->
<div class="modal-textarea-holder">
    <textarea name="text-field"><?php echo $text; ?></textarea>
</div><!--/modal-prod-list-holder -->
<div class="modal-files-holder">
    <h5><?php echo $this->labels['attached files']; ?></h5>
    <ul class="clearfix">
        <?php foreach($files as $nr => $file): ?>
            <li><?php echo $file->label; ?></li>
            <input type="hidden" name="files[<?php echo $nr; ?>]" value="<?php echo $file->id; ?>">
        <?php endforeach; ?>
    </ul>
</div>