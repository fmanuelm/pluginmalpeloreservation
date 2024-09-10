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
    //echo get_destinations();
    $form = '<div style="display: flex; align-items: center; justify-content: center;">
    ' . $logos_destino .'
    </div>
    <div id="yearTabs"></div>
    <div id="yearContents" style="display: flex;"></div>
    <form method="post" action="' . home_url() . '/' .  $web_destino . '" autocomplete="off">

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
                <input type="submit" name="enviar" value="Enviar" id="submit" class="btn-enviar" style="padding: 0px 6em; border-radius: 30px; background: #004b96; color: #fff; font-size: 22px; border: 1px solid #004b96;"/>
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
    $query = "SELECT id, destination, logo FROM $table_name";
    $resultados = $wpdb->get_results($query);
    
    $result = "";

    foreach ($resultados as $resultado) {
        $result .= "<div class='destino-logo' style='cursor: pointer;' data-destino='" . $resultado->id . "'><img style='margin:10px;'" . " src='" . $resultado->logo . "'/></div>";
    }

    return $result;
}