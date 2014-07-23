<?php /* @var $workers Array */ ?>
<?php /* @var $worker Users */ ?>

<?php foreach($workers as $worker): ?>
    <option value="<?php echo $worker->id;?>"><?php echo $worker->name.' '.$worker->surname;?></option>
<?php endforeach; ?>