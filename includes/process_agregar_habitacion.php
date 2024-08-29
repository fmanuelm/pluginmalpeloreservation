<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('/../wp-load.php');

function process_agregar_habitacion() {
	if (isset($_POST['submit'])) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms';
		
		$habitacion = $_POST['habitacion'];
		$price = $_POST['precio'];
		$personas = $_POST['personas'];
		$status = $_POST['estado'];

		$wpdb->query( $wpdb->prepare( 
		    "INSERT INTO $table_name(room_name, price, people, status)
		    VALUES(%s,%s,%d,%d)", 
		    $habitacion,
		    $price,
		    $personas,
		    $status
		) );

		wp_redirect( admin_url( 'admin.php?page=habitaciones' ) ); // Redirige a la subpágina después de guardar los datos
	  	exit;
	}
}