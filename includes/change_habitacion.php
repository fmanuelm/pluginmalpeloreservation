<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function change_habitacion() {
	global $wpdb;
	//$table_name1 = $wpdb->prefix . 'mapelo_reservation';
	//$table_name2 = $wpdb->prefix . 'mapelo_reservation_date';
	$table_name3 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id_habitacion = isset($_POST['mi_habitacion'])?$_POST['mi_habitacion']:0;
		
		$datos = $wpdb->get_row("SELECT * FROM $table_name3 WHERE id = $id_habitacion");

		// wp_redirect( admin_url( 'admin.php?page=custom-email' ) ); // Redirige a la subpágina después de guardar los datos
		wp_send_json($datos);
	}
	wp_die();
  	//exit;
}