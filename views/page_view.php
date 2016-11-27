<?=form_open(base_url('page/codeValidate'), array('class' => 'form-group')); ?>
<img src="<?=base_url('page/getCaptchaImg'); ?>">
<?=form_input(['name' => 'code', 'class' => 'form-control']); ?>
<?=form_submit('submit', 'submit'); ?>
<?=form_close(); ?>
<?=validation_errors(); ?>
<?=isset($validate_failed) ? $validate_failed : ''; ?>