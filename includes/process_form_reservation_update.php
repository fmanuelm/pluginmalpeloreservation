<?php
//echo "ready";
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
require_once('../../../../wp-load.php');
$base_url = home_url();
//echo $_SERVER['DOCUMENT_ROOT'];
// Verifica si el formulario se ha enviado

if (isset($_POST['submit'])) {
    // Conecta a la base de datos de Wordpress

    global $wpdb;

    $table_name1 = $wpdb->prefix . 'mapelo_reservation';
    $table_name2 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';

    $destino = $_POST['destino'];
    $fechas = $_POST['fechas'];
    $id = $_POST['reservation_id'];
    $habitaciones = isset($_POST['habSelect'])?$_POST['habSelect']:null;
    // Prepara los datos para ser insertados en la base de datos
    $data = array(
        'destination' => $destino
    );
    
    if (trim($destino) == '')
    {
        header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&updated=0");
        exit;
    }    
    
    $wpdb->update($table_name1, $data, ['id'=>$id]);
    $wpdb->delete($table_name2, ['id_reservation'=>$id]);
    

    $has_date = false;

    
    foreach ($fechas as $key => $value) {
        if (isset($habitaciones[$key]))
        {
            foreach ($habitaciones[$key] as $bedroom_id => $value2) {
                $data2 = array(
                                'id_reservation'=> $id,
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
    
    
    // Redirige a la página principal después de enviar el formulario
    header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&updated=1");
    //wp_redirect(home_url());
    exit;
}

?>
