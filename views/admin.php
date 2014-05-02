<?php
	wp_enqueue_media();
	$options = get_option('plugin_options');
?>

<div class="wrap">

	<form action="options.php" method="post">

		<?php settings_fields('plugin_options'); ?>

		<?php do_settings_sections('plugin'); ?>

		<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">


	</form>



</div>

