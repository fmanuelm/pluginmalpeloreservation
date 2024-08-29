<?php

require_once('../../../../wp-load.php');
$base_url = home_url();


if (isset($_POST['submit'])) {
    // Conecta a la base de datos de Wordpress

    global $wpdb;

    
    $table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms';

    // Recoge los datos del formulario
    $room_name = $_POST['room_name'];
    $precio = $_POST['precio'];
    $personas = $_POST['personas'];
    $habitaciones = $_POST['habitaciones'];
    $precios = $_POST['precios'];
    $estado = $_POST['estado'];
    $id = $_POST['id'];
    

    // Prepara los datos para ser insertados en la base de datos
    $data = array(
        'room_name' => $room_name,
        'price' => $precio,
        'people' => $personas,
        'status' => $estado
    );
    
    if (trim($room_name) == '')
    {
        header("Location: $base_url/wp-admin/admin.php?page=habitaciones&updated=0");
        exit;
    }
    
    
    $wpdb->update($table_name, $data, ['id'=>$id]);
    //$wpdb->delete($table_name2, ['id_reservation'=>$id]);
    

    
    // Redirige a la página principal después de enviar el formulario
    header("Location: $base_url/wp-admin/admin.php?page=habitaciones&updated=1");
    //wp_redirect(home_url());
    exit;
}

?>
