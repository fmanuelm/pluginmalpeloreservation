<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');
function enviar_formulario()
{
	
	if (isset($_POST['submit'])) {
		wp_redirect( '/' );
	}
}