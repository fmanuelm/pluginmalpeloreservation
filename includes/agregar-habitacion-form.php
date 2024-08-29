<?php

function agregar_habitacion() {
	//global $wpdb;
?>
<div class="wrap">
    <h1>Agregar Habitacion</h1>
    
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=process_agregar_habitacion' ) ); ?>">
      
      <br/>
      <label for="habitacion">Habitación: </label>
      <?php echo "<input type='text' id='habitacion' name='habitacion' value='' placeholder='Nombre habitacion' required/>"; ?>

      <br/>
      <br/>
      <label for="precio">Precio: </label>
      <?php echo "<input type='text' name='precio' id='precio' value='' placeholder='Precio' required/>"; ?>

      <br/>
      <br/>
      <label for="personas">Personas: </label>
      <?php echo "<input type='text' name='personas' id='personas' value='' placeholder='Numero de Personas' required/>"; ?>

      <br/>
      <br/>
      <label for="precio">Estado: </label>
      <?php echo "<select name='estado'>
      	<option value='0'>Deshabilitada</option>
      	<option value='1'>Habilitada</option>
      </select>"; ?>

      <?php submit_button( 'Guardar' ); ?>
    </form>
  </div>
<?php
}