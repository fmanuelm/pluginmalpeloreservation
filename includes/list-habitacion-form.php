<?php

function habitaciones() {
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms';
	$results = $wpdb->get_results("SELECT * FROM $table_name");
	wp_enqueue_script( 'my-plugin-script', plugin_dir_url( __FILE__ ) . '../_inc/habitaciones.js', array('jquery'), '1.0.0', true );
?>
<div class="wrap">
    <h1>Listado de habitaciones</h1>
    
    <?php
    	echo "<table>";
    	echo "<thead>";
	    echo "<tr>";
	      echo "<th style='width: 10%;'>Id</th>";
	      echo "<th style='width: 30%;'>Habitaciónn</th>";
	      echo "<th style='width: 20%;'>Precio</th>";
	      echo "<th style='width: 15%;'>Personas</th>";
	      echo "<th style='width: 15%;'>Estado</th>";
	      echo "<th style='width: 10%'; text-align: center'>Acción</th>";
	      echo "</tr>";
	      echo "</thead>";
		  foreach ($results as $row) {
		    $id = $row->id;
		    $habitacion = $row->room_name;
		    $precio = $row->price;
		    $personas = $row->people;
		    $estado = $row->status;
		    
		    //$room_name = $row->room_name;
		    //$price = $row->price;
		    
		    echo "<tr>";
		      echo "<td style='text-align: center;'>$id</td>";
		      echo "<td style='text-align: left;'>$habitacion</td>";
		      echo "<td style='text-align: center;'>" . number_format($precio, 2) . "</td>";
		      echo "<td style='text-align: center;'>$personas</td>";
		      echo "<td style='text-align: center;'>" . ($estado ==1?'Habilitada':'Deshabilitada') . "</td>";
		      echo "<td style='text-align: center'><a href='" . admin_url( 'admin.php?page=edit_habitacion&id=' . $id ) . "'>Edit</a> <a href='' data-id='$id' class='delete-hab-id'>Delete</a></td>";
		    echo "</tr>";
		  }
	  	  echo "</table>";
    ?>
    
  </div>
<?php
}