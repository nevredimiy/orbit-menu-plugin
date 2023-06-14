<div class="wrap orbit-options">

    <h1><?php _e( 'Theme Options Page', 'orbit-menu-plugin' ) ?></h1>


	<form action="options.php" method="POST">
  

	<?php settings_fields( 'orbit_menu_plugin_general_group' ); ?>
	<?php do_settings_sections( 'orbit-menu-plugin-options' ); ?>
	<?php submit_button(); ?>


    </form>

</div>