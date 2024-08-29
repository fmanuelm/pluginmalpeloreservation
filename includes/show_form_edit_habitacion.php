<?php
function show_form_edit_habitacion() {
	global $wpdb;
  	$id = $_GET['id'];
  	$table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms';
  	$row_bedrooms = $wpdb->get_results("SELECT * FROM $table_name
    WHERE id = $id");
    $habitacion = '';
    $precio = '';
    $personas = 0;
    $status = '';
    if ($row_bedrooms)
  	{
    	$habitacion = $row_bedrooms[0]->room_name;
    	$precio = $row_bedrooms[0]->price;
    	$personas = $row_bedrooms[0]->people;
    	$status = $row_bedrooms[0]->status;
    }
  	$url_home = home_url();
  	echo "<h1>Editar Habitación</h1>";
  	echo '<form method="POST" action="' . $url_home . '/wp-content/plugins/form-mapelo-reservation/includes/process_form_habitacion_update.php" autocomplete="off">';
  		echo "<div class='form-group' style='margin: 10px 0px;'>";
    		echo "<label for='room_name' style='display: block;'>Destino</label>";
    		echo "<input type='text' name='room_name' id='room_name' value='$habitacion'>";
  		echo "</div>";
  		echo "<div class='form-group' style='margin: 10px 0px;'>";
    		echo "<label for='precio' style='display: block;'>Precio</label>";
    		echo "<input type='text' name='precio' id='precio' value='$precio'>";
  		echo "</div>";
  		echo "<div class='form-group' style='margin: 10px 0px;'>";
    		echo "<label for='personas' style='display: block;'>Personas</label>";
    		echo "<input type='number' name='personas' id='personas' value='$personas'>";
  		echo "</div>";
  		echo "<div class='form-group' style='margin: 10px 0px;'>";
  			echo "<label for='estado' style='display: block;'>Estado</label>";
  			echo "<select name='estado'>";
  				echo "<option value='0'" . ($status == 0?'selected':'') . ">Inhabilitada</option>";
  				echo "<option value='1'" . ($status == 1?'selected':'') . ">Habilitada</option>";
  			echo "</select>";
		echo "</div>";
		echo "<br/>";
  		echo "<input type='hidden' name='id' value='" . $id . "'/>";
  		echo "<div class='form-group' style='margin: 10px 0px;'>";
    		echo '<input type="submit" value="Actualizar" name="submit" style="padding: 10px; background: blue; color: #fff; border: none; cursor: pointer;">';
  		echo "</div>";
  	echo "</form>";
}