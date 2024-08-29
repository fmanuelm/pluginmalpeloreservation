<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('/../wp-load.php');

function process_custom_email() {
	if (isset($_POST['submit'])) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mapelo_reservation_email';
		
		$html = $_POST['mensaje'];
		$email_address = $_POST['email_address'];
		$wpdb->query( $wpdb->prepare( 
		    "
		    UPDATE $table_name
		    SET email=%s,
		    email_address=%s
		    WHERE ID = 1
		    ", 
		    $html,
		    $email_address
		) );

		wp_redirect( admin_url( 'admin.php?page=custom-email' ) ); // Redirige a la subpágina después de guardar los datos
	  	exit;
	}
}