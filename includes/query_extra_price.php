<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function query_extra_price() {
	global $wpdb;
  	$table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$date_queried = isset($_POST['fecha'])?$_POST['fecha']:'';
		$id_reservation = isset($_POST['id_reservation'])?$_POST['id_reservation']:0;
		$bedroom_id = isset($_POST['bedroom_id'])?$_POST['bedroom_id']:0;

		$datos = $wpdb->get_results("
    SELECT $table_name.custom_price FROM $table_name WHERE $table_name.fecha = '$date_queried' AND $table_name.id_reservation = $id_reservation AND $table_name.bedroom_id = $bedroom_id");

		// wp_redirect( admin_url( 'admin.php?page=custom-email' ) ); // Redirige a la subpágina después de guardar los datos

		if (!empty($datos)) {
		    $precio = $datos[0]->custom_price;
		    wp_send_json(['datos'=>$precio]);
		} else {
		    //echo 'No se encontraron resultados.';
		    wp_send_json(['datos'=>0]);
		}
	}
	wp_die();
  	//exit;
}