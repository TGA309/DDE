<?php  if (count($errors_register) > 0) : ?>
    <div class="error">
        <?php foreach ($errors_register as $error_register) : ?>
  	        <p><?php echo $error_register ?></p>
  	    <?php endforeach ?>
    </div>
<?php  endif ?>