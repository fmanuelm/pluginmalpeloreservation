<?php

function dest_page() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'mapelo_reservation_destpage';
	$datos = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
	$slug = isset($datos->slug)?$datos->slug:'';
  
	
?>
<div class="wrap">
    <h1>Slug de pagina de Destino</h1>
    
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=process_destpage' ) ); ?>">
      <br/>
      <?php echo "<input type='text' name='slug' value='$slug' placeholder='Slug Pagina de Destino' required/>"; ?>

      <?php submit_button( 'Guardar' ); ?>
    </form>
  </div>
<?php
}