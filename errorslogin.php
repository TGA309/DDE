<?php  if (count($errors_login) > 0) : ?>
	<div class="error">
  		<?php foreach ($errors_login as $error_login) : ?>
  			<p><?php echo $error_login ?></p>
  		<?php endforeach ?>
	</div>
<?php  endif ?>