<?php
/*
Plugin Name: Form Mapelo Reservation
Plugin URI: https://www.linkedin.com/in/felix-manuel-montero-ramos-33876346/
Description: Form for make reservation.
Version: 1.0.0
Author: Felix Manuel
Author URI: https://www.linkedin.com/in/felix-manuel-montero-ramos-33876346/
License: GPLv2 or later
*/
//require_once('../../../wp-load.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/class-plugin-activator.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/mapelo-reservation-uninstall.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/custom-email-form.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/destpage-form.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/agregar-habitacion-form.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/list-habitacion-form.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/process_custom_email.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/process_agregar_habitacion.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/process_destpage.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/delete_destination.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/delete_habitacion.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/get_habitaciones.php');

require_once(plugin_dir_path( __FILE__ ) . 'includes/form_reservation.php');
require_once(plugin_dir_path( __FILE__ ) . 'shortcodes/form_reservation_step1.php');
//require_once(plugin_dir_path( __FILE__ ) . 'shortcodes/change_destination_form.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/change_destination.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/query_date.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/change_habitacion.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/change_fecha.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/enviar_formulario.php');
require_once(plugin_dir_path( __FILE__ ) . 'includes/show_form_edit_habitacion.php');



function form_mapelo_reservation() {
  global $wpdb;
  wp_enqueue_script( 'my-plugin-script', plugin_dir_url( __FILE__ ) . '_inc/form_back.js', array('jquery'), '1.0.0', true );
  $name_table = $wpdb->prefix . 'mapelo_reservation';
  $name_table1 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
  $results = $wpdb->get_results("SELECT * FROM $name_table");
  $habitaciones = $wpdb->get_results("SELECT * FROM $name_table1 WHERE status = 1");


  if (isset($_GET['new']) && $_GET['new']==1)
  {
    echo "<p>Se ha creado perfectamente</p>";
  }
  if (isset($_GET['new']) && $_GET['new']==0)
  {
    echo "<p>No se creó, porque se quedaron campos vacíos. Asegurese de no dejar campos vacíos.</p>";
  }
  if (isset($_GET['updated']) && $_GET['updated'] ==1)
  {
    echo "<p>Se ha actualizado perfectamente</p>";
  }
  if (isset($_GET['new']) && $_GET['new']==0)
  {
    echo "<p>No se actualizó, porque se quedaron campos vacíos. Asegurese de no dejar campos vacíos.</p>";
  }
  $url_home = home_url();
  echo '<form method="POST" action="' . $url_home . '/wp-content/plugins/form-mapelo-reservation/process_form_reservation.php" id="create_reservation">';
  $habitaciones_json = json_encode($habitaciones);
  echo "<input type='hidden' value='$habitaciones_json' name='habitaciones_json' id='habitaciones_json'/>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
  echo "<label for='destino' style='display:block'>Destino</label>";
  echo '<input type="text" name="destino" id="destino" class="form-control">';
  echo "</div>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
    echo "<label for='logo' style='display: block;'>Imagen URL</label>";
    echo "<input type='text' name='logo' id='logo'>";
  echo "</div>";
  
  
  
  echo "<div id='habitaciones'>";
    echo "<div class='form-group' style='margin: 10px 0px;'>";
      echo '<input type="date" name="fechas[]" id="fecha1" class="form-control fecha" style="margin-right: 20px"><br/><br/>';
        foreach ($habitaciones as $row) {
          $id = $row->id;
          $room_name = $row->room_name;
          $price = $row->price;
          $people = $row->people;
          echo "<span style='margin-right: 10px;'><input type='checkbox' name='habSelect[0][$id]'> $room_name (Personas: <strong>$people</strong> / Precio x Persona: <strong>$price</strong>)<br/> Disponible: <input type='radio' name='habDisponible[$id]' value='1'/> Si <input type='radio' name='habDisponible[$id]' value='0'/> No</span><br/><br/>";
        }
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
    echo "<input type='button' value='+ Agregar Fecha' id='addBedroom' style='background: green; color: #fff; padding: 5px 10px; border: none; cursor: pointer;'>";
  echo "</div>";
  echo "<br/>";
  echo '<input type="submit" value="Guardar" name="submit" style="padding: 10px; background: blue; color: #fff; border: none; cursor: pointer;">';
  echo '</form>';
  echo "<br/>";
  echo "<input type='hidden' name='mode' id='mode' value='new'/>";
  echo "<table>";
    echo "<tr>";
      echo "<td>Id</td>";
      echo "<td>Destino</td>";
      
      echo "<td>Acción</td>";
    echo "</tr>";
  foreach ($results as $row) {
    $id = $row->id;
    $destination = $row->destination;
    
    //$room_name = $row->room_name;
    //$price = $row->price;
    $room_name = '';
    $price = '';
    echo "<tr>";
      echo "<td>$id</td>";
      echo "<td>$destination</td>";
      
      echo "<td><a href='" . admin_url( 'admin.php?page=edit_destination&id=' . $id ) . "'>Edit</a> <a href='' data-id='$id' class='delete-id'>Delete</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}

function add_page_to_menu() {
    add_menu_page("Form Mapelo Reservation", "Form Malelo Reservation", "manage_options", "form-mapelo-reservation", "form_mapelo_reservation", "", null);

    add_submenu_page(null, 'Edit', 'Edit', 'manage_options', 'edit_destination', 'show_form_edit');
    
    add_submenu_page(null, 'Edit', 'Edit', 'manage_options', 'edit_habitacion', 'show_form_edit_habitacion');

}


function add_custom_message() {
  add_submenu_page(
    'form-mapelo-reservation',
    'Perzonalizar Correo',
    'Perzonalizar Correo',
    'manage_options',
    'custom-email',
    'custom_email'
  );
}

function add_list_bedrooms() {
  add_submenu_page(
    'form-mapelo-reservation',
    'Habitaciones',
    'Habitaciones',
    'manage_options',
    'habitaciones',
    'habitaciones'
  );
}

function add_add_bedroom() {
  add_submenu_page(
    'form-mapelo-reservation',
    'Agregar Habitación',
    'Agregar Habitación',
    'manage_options',
    'agregar-habitacion',
    'agregar_habitacion'
  );
}

function add_destpage() {
  add_submenu_page(
    'form-mapelo-reservation',
    'Slug de Pagina de Destino',
    'Slug de Pagina de Destino',
    'manage_options',
    'dest-page',
    'dest_page'
  );
}


function show_form_edit() {
  wp_enqueue_script( 'my-plugin-script', plugin_dir_url( __FILE__ ) . '_inc/form_back.js', array('jquery'), '1.0.0', true );
  global $wpdb;
  $id = $_GET['id'];
  $name_table = $wpdb->prefix . 'mapelo_reservation';
  $table_name2 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
  $table_name3 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
  
  $results = $wpdb->get_results("SELECT * FROM $name_table");
  $habitaciones = $wpdb->get_results("SELECT * FROM $table_name3 WHERE status = 1");

  $row = $wpdb->get_results("SELECT $name_table.* FROM $name_table
    WHERE $name_table.id = $id");
  $destination = $row[0]->destination;
  $logo = $row[0]->logo;
  
  $row_date = $wpdb->get_results("SELECT * FROM $table_name2
    WHERE id_reservation = $id"); 
  $row_bedrooms = $wpdb->get_results("
    SELECT  $name_table.id AS id_reservation, $name_table.destination, $table_name3.id as id_room, $table_name3.room_name, $table_name3.price, $table_name3.people, $table_name2.disponible, $table_name2.fecha FROM $table_name2 
LEFT JOIN $name_table 
ON $name_table.id = $table_name2.id_reservation
LEFT JOIN $table_name3 
ON $table_name3.id = $table_name2.bedroom_id
WHERE $table_name2.id_reservation = $id GROUP BY $table_name2.fecha");
  
  $row_bedrooms2 = $wpdb->get_results("
    SELECT  $name_table.id AS id_reservation, $name_table.destination, $table_name3.id as id_room, $table_name3.room_name, $table_name3.price, $table_name3.people, $table_name2.disponible, $table_name2.fecha FROM $table_name2 
LEFT JOIN $name_table 
ON $name_table.id = $table_name2.id_reservation
LEFT JOIN $table_name3 
ON $table_name3.id = $table_name2.bedroom_id
WHERE $table_name2.id_reservation = $id GROUP BY $table_name2.id");

  
  //$destino = $row_bedrooms[0]->destination;
  $url_home = home_url();
  echo "<h1>Editar Destino</h1>";
  echo '<form method="POST" action="' . $url_home . '/wp-content/plugins/form-mapelo-reservation/includes/process_form_reservation_update.php" autocomplete="off" id="create_reservation">';
  $habitaciones_json = json_encode($habitaciones);
  
  echo "<input type='hidden' value='$habitaciones_json' name='habitaciones_json' id='habitaciones_json'/>";
  echo "<input type='hidden' name='reservation_id' value='$id'/>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
    echo "<label for='destino' style='display: block;'>Destino</label>";
    echo "<input type='text' name='destino' id='destino' value='$destination'>";
  echo "</div>";
  echo "<br/>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
    echo "<label for='logo' style='display: block;'>Imagen URL</label>";
    echo "<input type='text' name='logo' id='logo' value='$logo'>";
  echo "</div>";
  echo "<br/>";
  echo "<div id='habitaciones'>";
  $fila = 0;
    foreach ($row_bedrooms as $row) {
      
      $fecha = $row->fecha;
      $disponible = $row->disponible;
      
      
      echo "<div class='form-group' style='margin: 10px 0px; position: relative;'>";
        echo '<input type="date" name="fechas[]" value="' . $fecha . '" class="form-control fecha" style="margin-right: 20px">';
            foreach ($habitaciones as $row1) {
              $id = $row1->id;
              $room_name = $row1->room_name;
              $price = $row1->price;
              $people = $row1->people;
              $checked = '';
              $disponibleCheckedSi = '';
              $disponibleCheckedNo = '';
              foreach ($row_bedrooms2 as $row2)
              {
                
                //echo $row2->id_room . " - " . $row1->id . " / ";
                if (($row2->id_room === $row1->id) && ($fecha === $row2->fecha))
                {

                  $checked = 'checked';
                  if ($row2->disponible == 1)
                  {
                    $disponibleCheckedSi = 'checked';
                  }
                  else {
                    $disponibleCheckedNo = 'checked';
                  }
                }
              }
              if ($disponibleCheckedSi === '' && $disponibleCheckedNo === '')
              {
                $disponibleCheckedSi = 'checked';
              }

              echo "<span style='margin-right: 10px'><br/><input type='checkbox' name='habSelect[$fila][$id]' $checked> $room_name (Personas: <strong>$people</strong> / Precio x Persona: <strong>$price</strong>) <br/> Disponible: <input type='radio' name='habDisponible[$fila][$id]' $disponibleCheckedSi value='1'/> Si <input type='radio' name='habDisponible[$fila][$id]' $disponibleCheckedNo value='0'/> No</span></span>";
              $checked = '';
            }
            echo "<button class='btn-danger btn remove-bedroom' style='position: absolute; right: 10px; top: 10px;  font-size: 20px; width: 30px;'>x</button>";
            $fila++;
      echo "</div>";
    }
  echo "</div>";
  echo "<div class='form-group' style='margin: 10px 0px;'>";
    echo "<input type='button' value='+ Agregar Fecha' id='addBedroom' style='background: green; color: #fff; padding: 5px 10px; border: none; cursor: pointer;'>";
  echo "</div>";
  echo "<br/>";
  echo '<input type="submit" value="Actualizar" name="submit" style="padding: 10px; background: blue; color: #fff; border: none; cursor: pointer;">';
  echo '</form>';
  echo "<input type='hidden' name='mode' id='mode' value='update'/>";
  echo "<input type='hidden' name='no_fechas' id='no_fechas' value='" . count($row_bedrooms) . "'/>";
}
function my_plugin_scripts()
{
  wp_enqueue_script( 'my-plugin-css', plugin_dir_url( __FILE__ ) . 'css/form-mapelo-reservation.css');
}

register_activation_hook(__FILE__, 'reservation_activate');
register_uninstall_hook( __FILE__, 'mapelo_reservation_uninstall' );
//enviar_formulario
add_action('wp_ajax_enviar_formulario', 'enviar_formulario');

add_action( 'init', 'my_plugin_init' );

add_action( 'wp_enqueue_scripts', 'my_plugin_scripts2' );

function my_plugin_scripts2() {
    wp_register_style( 'my-plugin-css', plugins_url( 'css/form-mapelo-reservation.css', __FILE__ ) );
    wp_enqueue_style( 'my-plugin-css' );
}

function my_plugin_init() {

  add_action( 'admin_enqueue_scripts', 'my_plugin_scripts' );
  
  
  add_action('admin_menu', 'add_page_to_menu');
  add_action('admin_menu', 'add_custom_message');

  add_action('admin_menu', 'add_list_bedrooms');

  add_action('admin_menu', 'add_add_bedroom');

  add_action('admin_menu', 'add_destpage');

  add_action( 'admin_post_process_custom_email', 'process_custom_email' );
  add_action( 'admin_post_nopriv_process_custom_email', 'process_custom_email' );

  add_action( 'admin_post_process_agregar_habitacion', 'process_agregar_habitacion' );
  add_action( 'admin_post_nopriv_process_agregar_habitacion', 'process_agregar_habitacion' );
  

  add_action( 'admin_post_process_destpage', 'process_destpage' );
  add_action( 'admin_post_nopriv_process_destpage', 'process_destpage' );

  add_action('wp_ajax_delete_destination', 'delete_destination');
  add_action('wp_ajax_delete_habitacion', 'delete_habitacion');
  add_action('wp_ajax_get_habitaciones', 'get_habitaciones');

  add_filter( 'the_content', 'show_form_reservation' );

  add_shortcode('reservation_step1', 'form_reservation_step1');

  add_action('wp_ajax_change_destination', 'change_destination');
  add_action('wp_ajax_nopriv_change_destination', 'change_destination');

  add_action('wp_ajax_query_date', 'query_date');
  add_action('wp_ajax_nopriv_query_date', 'query_date');

  add_action('wp_ajax_change_habitacion', 'change_habitacion');
  add_action('wp_ajax_nopriv_change_habitacion', 'change_habitacion');

  add_action('wp_ajax_change_fecha', 'change_fecha');
  add_action('wp_ajax_nopriv_change_fecha', 'change_fecha');
}
register_activation_hook( __FILE__, 'my_plugin_activate' );

function my_plugin_activate() {
  if ( ! is_plugin_active( 'wp-editor/wpeditor.php' ) ) {
    wp_die( 'Lo siento, pero para activar este plugin es necesario tener instalado y activado el plugin wp-editor.' );
  }
}

?>