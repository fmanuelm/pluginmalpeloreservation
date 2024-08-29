<?php
require_once('../../../wp-load.php');
$base_url = home_url();
// Verifica si el formulario se ha enviado

if (isset($_POST['submit'])) {
    // Conecta a la base de datos de Wordpress

    global $wpdb;

    $table_name1 = $wpdb->prefix . 'mapelo_reservation';
    $table_name2 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';

    // Recoge los datos del formulario
    $destino = $_POST['destino'];
    $fechas = $_POST['fechas'];
    
    $habitaciones = isset($_POST['habSelect'])?$_POST['habSelect']:null;
    
    // Prepara los datos para ser insertados en la base de datos
    $data = array(
        'destination' => $destino,
    );
    
    if (trim($destino) === '')
    {
        header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&new=0");
        exit;
    }

    // Inserta los datos en la base de datos
    $wpdb->insert($table_name1, $data);
    $inserted_id = $wpdb->insert_id;
    $has_date = false;
    
    
    foreach ($fechas as $key => $value) {
        if (isset($habitaciones[$key]))
        {
            
            foreach ($habitaciones[$key] as $bedroom_id => $value2) {
                $data2 = array(
                                'id_reservation'=> $inserted_id,
                                'bedroom_id' => $bedroom_id,
                                'fecha' => $value
                            );
                if ($value !== '' && $value !== null)
                {
                    $wpdb->insert($table_name2, $data2);
                    $has_date = true;
                }
            }
        }
        
    }
    /*
    $i = 0;
    foreach ($habitaciones as $key => $value) {
        $data3 = array('room_name' => $value,
                        'price' => $precios[$i],
                        'people' => $personas[$i],
                        'status' => 1,
                        'id_reservation'=> $inserted_id);
        if ($value !== '' && $value !== null && $personas[$i] !== '' && $personas[$i] !== null)
        {
            $wpdb->insert($table_name3, $data3);
            $has_date = true;
        }
        $i +=1;
    }
    */
    // Redirige a la página principal después de enviar el formulario

    header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&new=1");
    exit;
}

?>
