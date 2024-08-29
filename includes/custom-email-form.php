<?php

function custom_email() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'mapelo_reservation_email';
	$datos = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
	$content = isset($datos->email)?$datos->email:'';
  $email_address = isset($datos->email_address)?$datos->email_address:'';
	$editor_id = 'mensaje';
?>
<div class="wrap">
    <h1>Personalizar Correo</h1>
    <p>Los tags que puedes usar son: <strong>{nombre}, {destino}, {fecha}</strong></p>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=process_custom_email' ) ); ?>">
      
      <?php wp_editor( $content, $editor_id, $settings = array() ); ?>
      <br/>
      <?php echo "<input type='email' name='email_address' value='$email_address' placeholder='Dirección Email' required/>"; ?>

      <?php submit_button( 'Guardar Plantilla' ); ?>
    </form>
  </div>
<?php
}