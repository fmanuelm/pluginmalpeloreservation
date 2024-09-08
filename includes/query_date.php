<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function query_date() {
	global $wpdb;
  	$table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$date_queried = isset($_POST['fecha'])?$_POST['fecha']:'';
		

		$datos = $wpdb->get_results("
    SELECT count($table_name.id) AS id_reservation FROM $table_name WHERE $table_name.fecha = '$date_queried' AND $table_name.disponible = 1 GROUP BY $table_name.fecha");

		// wp_redirect( admin_url( 'admin.php?page=custom-email' ) ); // Redirige a la subpágina después de guardar los datos

		if (!empty($datos)) {
		    $numero_reservas = $datos[0]->id_reservation;
		    //echo 'Número de reservas: ' . $numero_reservas;
		    wp_send_json(['datos'=>$numero_reservas]);
		} else {
		    //echo 'No se encontraron resultados.';
		    wp_send_json(['datos'=>0]);
		}
	}
	wp_die();
  	//exit;
}