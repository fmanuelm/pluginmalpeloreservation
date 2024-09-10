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
    $logo = $_POST['logo'];
    $fechas = $_POST['fechas'];
    $id = $_POST['reservation_id'];
    $habitaciones = isset($_POST['habSelect'])?$_POST['habSelect']:null;
    $habDisponible = isset($_POST['habDisponible'])?$_POST['habDisponible']:null;
    echo "habitaciones: ";
    print_r($habitaciones);
    echo "<br>";
    echo "hab disponible: ";
    print_r($habDisponible);
    echo "<br>";
    // Prepara los datos para ser insertados en la base de datos
    $data = array(
        'destination' => $destino,
        'logo' => $logo
    );
    
    if (trim($destino) == '')
    {
        header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&updated=0");
        exit;
    }    
    
    $wpdb->update($table_name1, $data, ['id'=>$id]);
    $wpdb->delete($table_name2, ['id_reservation'=>$id]);
    

    $has_date = false;

    $i = 0;
    foreach ($fechas as $key => $value) {
        
        if (isset($habitaciones[$key]))
        {
            foreach ($habitaciones[$key] as $bedroom_id => $value2) {
                $disponible = $habDisponible[$i][$bedroom_id];
                
                $data2 = array(
                                'id_reservation'=> $id,
                                'bedroom_id' => $bedroom_id,
                                'fecha' => $value,
                                'disponible' => $disponible
                            );
                
                
                if ($value !== '' && $value !== null)
                {
                    $wpdb->insert($table_name2, $data2);
                    $has_date = true;
                }
                
            }
            $i = $i + 1;
        }
        
    }
    
    
    // Redirige a la página principal después de enviar el formulario
    header("Location: $base_url/wp-admin/admin.php?page=form-mapelo-reservation&updated=1");
    //wp_redirect(home_url());
    exit;
}

?>
