<?php
function form_reservation_step1($atts) {
    wp_enqueue_script( 'mi-script', plugins_url( 'js/form-reservation.js', __FILE__ ), array( 'jquery' ), '1.0', true );

    global $wpdb;
    $table_name = $wpdb->prefix . 'mapelo_reservation_destpage';
    $datos = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
    $slug = isset($datos->slug)?$datos->slug:'';

    $web_destino = $slug;
    $img_destinations[] = Array();
    $logos_destino = get_destinations_img();
    $destinos_json = get_disponibilidad();
    //echo get_destinations();
    $langYear = "Year";
    if (get_locale() === 'es-ES')
    {
        $langYear = "Año";
    }
    $form = '<div style="display: flex; align-items: center; justify-content: center; justify-content: center;" id="destinos-logos">
    ' . $logos_destino .'
    </div>
    <input type="hidden" id="current-year" value="' . date('Y') . '"/>
    <input type="hidden" id="destino-json" value='."'". $destinos_json . "'". '/>
    <h2 style="display: none; text-align: center; font-size: 40px; color: #004b96; font-family: Roboto; margin-bottom: 30px;" id="titulo-destino"></h2>
    <h2 style="text-align: center; font-size: 40px; color: #004b96; font-family: Roboto; margin-bottom: 30px;">'  . "Select " . $langYear . '</h2>
    <div id="yearTabs"></div>
    <div id="yearContents" style="display: flex; flex-wrap: wrap;
  gap: 10px; justify-content: center;"></div>
    <form method="post" id="formulario-reserva" action="' . home_url() . '/' .  $web_destino . '" autocomplete="off">

                <div class="form-group" style="display: none;">
                    <label for="destino">Destino:</label>
                    <select name="destino" id="destino" class="form-control">
                        ' . get_destinations() . '
                    </select>
                </div>
                <div class="form-group" style="display: none;">
                    <label for="fecha">Fecha:</label>
                    <select name="fecha" id="fecha" class="form-control">
                        <option value="1"></option>
                    </select>
                </div>
                <div class="form-group" style="text-align: center">
                    <label for="habitacion" style="font-size: 30px; color: #004b96;">Select a Cabin:</label>
                    <select name="habitacion" id="habitacion" class="form-control" style="border-radius: 20px;">
                        <option value="0" selected></option>
                    </select>
                </div>
                <div class="form-group"  style="text-align: center; margin-top: 30px;">
                    <label for="personas" style="font-size: 30px; color: #004b96;">Divers:</label>
                    <select name="personas" id="personas" class="form-control" class="form-control" style="border-radius: 20px;">
                    </select>
                </div>
                <div class="form-group" style="text-align: center; margin-top: 40px;">
                    <label for="total" style="color: #004b96; font-size: 30px;">Total: $</label>
                    <input type="text" name="total" id="total"  disabled="disabled" value="" class="form-control" style="font-weight: 100; width: 100px; padding: 1px 10px; display: inline-block; width: calc(93% - 90px); border-radius: 30px;"/>
                    </div>
                <br/>
                <input type="hidden" name="form1" value="1"/>
                <div class="form-group" style="text-align: center">
                <input type="submit" name="enviar" value="Enviar" id="submit" class="btn-enviar"/>
                </div>
              </form>';

    

    return $form;
}

function get_destinations()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'mapelo_reservation';
    $query = "SELECT id, destination FROM $table_name";
    $resultados = $wpdb->get_results($query);
    
    $result = "<option value='0' selected>* Seleccione un Destino</option>";

    foreach ($resultados as $resultado) {
        $result .= "<option value='" . $resultado->id . "'>" . $resultado->destination . "</option>";
    }

    return $result;
}
function get_destinations_img()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'mapelo_reservation';
    $query = "SELECT id, destination, logo FROM $table_name ORDER BY id DESC";
    $resultados = $wpdb->get_results($query);
    
    $result = "";

    foreach ($resultados as $resultado) {
        $display = "";
        
        if ($_SERVER['HTTP_HOST'] !== 'localhost')
        {
            if ($resultado->id == 1)
            {
                $display = "display: none;";
            }
        }
        
        $result .= "<div class='destino-logo' style='cursor: pointer;$display' data-destinoname='$resultado->destination' data-destino='" . $resultado->id . "'><img " . " src='" . $resultado->logo . "'/></div>";
    }

    return $result;
}

function get_disponibilidad()
{
    global $wpdb;
    $paquete_id = 4;
    if ($_SERVER['HTTP_HOST'] === 'localhost')
    {
        $paquete_id = 28;
    }
    
    $table_name = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
    $query = "SELECT count($table_name.id) AS cantidad, $table_name.fecha, $table_name.id_reservation FROM $table_name WHERE $table_name.disponible = 1 AND $table_name.id_reservation = $paquete_id GROUP BY $table_name.fecha";
    
    $resultados = $wpdb->get_results($query);
    
    $result = [];

    foreach ($resultados as $resultado) {
        $result[] = $resultado->fecha;
    }

    return json_encode($result);

}