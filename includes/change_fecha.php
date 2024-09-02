<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function change_fecha() {
	global $wpdb;
	$name_table = $wpdb->prefix . 'mapelo_reservation';
  	$table_name2 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
  	$table_name3 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id_reservation = isset($_POST['mi_destino'])?$_POST['mi_destino']:0;
		$fecha = isset($_POST['fecha'])?$_POST['fecha']:0;

		$datos = $wpdb->get_results("
    SELECT $name_table.id AS id_reservation, $name_table.destination, $table_name3.id as id_room, $table_name3.status, $table_name3.room_name, $table_name3.price, $table_name3.people, $table_name2.disponible, $table_name2.fecha FROM $table_name2 
LEFT JOIN $name_table 
ON $name_table.id = $table_name2.id_reservation
LEFT JOIN $table_name3 
ON $table_name3.id = $table_name2.bedroom_id
WHERE $table_name2.id_reservation = $id_reservation AND $table_name2.fecha = '$fecha' GROUP BY $table_name3.id");

		// wp_redirect( admin_url( 'admin.php?page=custom-email' ) ); // Redirige a la subpágina después de guardar los datos
		wp_send_json(['datos'=>$datos]);
	}
	wp_die();
  	//exit;
}