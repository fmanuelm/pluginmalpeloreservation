<?php
//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');
function form_reservation() {
	$fields = '';
	if (isset($_POST['enviar']) && isset($_POST['form1']))
	{
		/*
		if (isset($_POST['nombre']) && isset($_POST['email'])) {
        $nombre = sanitize_text_field($_POST['nombre']);
        $email = sanitize_email($_POST['email']);
        $mensaje = "Nombre: $nombre\nEmail: $email";
        wp_mail('destinatario@example.com', 'Nuevo formulario enviado', $mensaje);
        $form = '¡Gracias por enviar el formulario!';
    	}
		*/
		$destination = $_POST['destino'];
		$people = $_POST['personas'];
		$room_name = $_POST['habitacion'];
		$date = $_POST['fecha'];
    $url_home = home_url();
    $total = (isset($_POST['total']))?$_POST['total']:'';
		$fields = "
			<input type='hidden' value='$destination' name='destino' id='destino'/>
			<input type='hidden' value='$people' name='personas' id='personas'/>
			<input type='hidden' value='$room_name' name='habitacion' id='habitacion'/>
			<input type='hidden' value='$date' name='fecha' id='fecha'/>
            <input type='hidden' value='$total' name='total' id='total'/>
		";

        return '<form action="#" method="post">
              <input type="hidden" name="action" value="enviar_formulario">
              <div class="form-group">
                  <label for="nombre">Nombre *:</label>
                  <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" required>
              </div>
              <div class="form-group">
                  <label for="correo">Correo *:</label>
                  <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo" required>
              </div>
              <div class="form-group">
                  <label for="correo">Teléfono *:</label>
                  <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required>
              </div>
              <div class="form-group">
                <label for="correo">País:</label>
                <input type="text" id="pais" name="pais" class="form-control" placeholder="País">
              </div>
              <div class="form-group">
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" class="form-control" placeholder="Mensaje"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Confirmar Reserva" name="enviar" class="btn-enviar"><a href="#" class="btn-atras">Atrás</a>
              </div>' . $fields . '</form>';
	}
    if (isset($_POST['enviar']) && isset($_POST['nombre']))
    {
        $destino_id = isset($_POST['destino'])?$_POST['destino']:'';
        $nombre = isset($_POST['nombre'])?$_POST['nombre']:'';
        $correo = isset($_POST['correo'])?$_POST['correo']:'';
        $telefono = isset($_POST['telefono'])?$_POST['telefono']:'';
        $pais = isset($_POST['pais'])?$_POST['pais']:'';
        $mensaje = isset($_POST['mensaje'])?$_POST['mensaje']:'';
        $fecha = isset($_POST['fecha'])?$_POST['fecha']:'';
        $habitacion = isset($_POST['habitacion'])?$_POST['habitacion']:'';
        $personas = isset($_POST['personas'])?$_POST['personas']:'';
        $total = isset($_POST['total'])?$_POST['total']:'';
        global $wpdb;
        $table_email = $wpdb->prefix . 'mapelo_reservation_email';
        $table_bedrooms = $wpdb->prefix . 'mapelo_reservation_bedrooms';

        $datos = $wpdb->get_row("SELECT * FROM $table_email WHERE id = 1");
        $datos1 = $wpdb->get_row("SELECT * FROM $table_bedrooms WHERE id = $habitacion");
        $precio_x_habitacion = 0;
        $nombre_habitacion = '';

        if ($datos1)
        {
          $precio_x_habitacion = isset($datos1->price)?$datos1->price:'';
          $nombre_habitacion = isset($datos1->room_name)?$datos1->room_name:'';
        }

        $content = isset($datos->email)?$datos->email:'';
        $email_address = isset($datos->email_address)?$datos->email_address:'';

        $table_destino = $wpdb->prefix . 'mapelo_reservation';
        $datos_destino = $wpdb->get_row("SELECT * FROM $table_destino WHERE id = $destino_id");
        $content = str_replace('{destino}', $datos_destino->destination, $content);
        $content = str_replace('{nombre}', $nombre, $content);
        $content = str_replace('{fecha}', $fecha, $content);
        
        // reemplaza en content {nombre}, {email}, {destino}, {habitacion}, {total}
        // me falta con fecha y habitacion
        $to = $email_address;
        $subject = 'Reserva Confirmada';
        $subject1 = 'Reserva en Pagina Web';
        $message = $content;
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // mensaje al cliente
        wp_mail( $correo, $subject, $message, $headers );
        $total_reserva = $precio_x_habitacion * $personas;
        $message1 = "De: $correo <br/>
        Nombre: $nombre <br/>
        Destino: " . $datos_destino->destination . "<br/>
        Habitacion: $nombre_habitacion <br/>
        Personas: $personas <br/>
        Precio Hab: $precio_x_habitacion <br/>
        Total: $total_reserva <br/>
        Fecha: $fecha <br/>
        Pais: $pais <br/>
        Telefono: $telefono <br/>
        Mensaje: $mensaje";
        // mensaje al administrador
        wp_mail( $to, $subject1, $message1, $headers );
        return "<div style='background: green; padding: 10px; color: #fff; border-radius: 5px;'>Su formulario ha sido enviado. Un asesor le contactá lo más breve posible. </div>";
    }
    
}

function show_form_reservation($content) {
    // Verifica si la página actual es la página deseada
    global $wpdb;
    $table_destpage = $wpdb->prefix . 'mapelo_reservation_destpage';

    $datos = $wpdb->get_row("SELECT * FROM $table_destpage WHERE id = 1");
    
    if ( is_page( $datos->slug ) ) {
        // Agrega el formulario al gancho de acción 'the_content'
        //add_action( 'the_content', 'form_reservation' );
        $content .= form_reservation();
    }
    return $content;
}