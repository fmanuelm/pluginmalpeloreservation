<?php
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	global $form_mapelo_reservation_version;

	$form_mapelo_reservation_version = "1.0.0";	

	function reservation_activate() { 
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
	    
		global $form_mapelo_reservation_version;

		$table_name1 = $wpdb->prefix . 'mapelo_reservation';
		$table_name2 = $wpdb->prefix . 'mapelo_reservation_date';
		$table_name3 = $wpdb->prefix . 'mapelo_reservation_email';
		$table_name4 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
		$table_name5 = $wpdb->prefix . 'mapelo_reservation_destpage';
		$table_name6 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
		

		$sql1 = "CREATE TABLE IF NOT EXISTS $table_name1 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			destination varchar(200) NOT NULL,
			created_at timestamp DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $charset_collate;";	

		$sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			fecha date,
			status integer DEFAULT 1,
			id_reservation bigint(10) NOT NULL,
			PRIMARY KEY (id),
			KEY id_reservation (id_reservation),
			CONSTRAINT fk_mapelo_reservation_id FOREIGN KEY (id_reservation) REFERENCES $table_name1(id) ON DELETE CASCADE
		) $charset_collate;";
		
		$sql3 = "CREATE TABLE IF NOT EXISTS $table_name3 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			email text,
			email_address varchar(50),
			PRIMARY KEY  (id)
			) $charset_collate;
		";
		/*
		$sql4 = "CREATE TABLE IF NOT EXISTS $table_name4 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			room_name varchar(100) DEFAULT '' NOT NULL,
			price float,
			people integer NOT NULL,
			status integer DEFAULT 1,
			id_reservation bigint(10) NOT NULL,
			PRIMARY KEY (id),
			KEY id_reservation (id_reservation),
			CONSTRAINT fk_mapelo_reservation_id2 FOREIGN KEY (id_reservation) REFERENCES $table_name1(id) ON DELETE CASCADE
		) $charset_collate;";
		*/
		$sql4 = "CREATE TABLE IF NOT EXISTS $table_name4 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			room_name varchar(100) DEFAULT '' NOT NULL,
			price float,
			people integer NOT NULL,
			status integer DEFAULT 1,
			PRIMARY KEY (id)
		) $charset_collate;";

		$sql5 = "CREATE TABLE IF NOT EXISTS $table_name5 (
			id bigint(10) NOT NULL AUTO_INCREMENT,
			slug varchar(200) DEFAULT '' NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		$sql06 = "CREATE TABLE IF NOT EXISTS $table_name6 (
		  id bigint(10) NOT NULL AUTO_INCREMENT,
		  id_reservation bigint(10) NOT NULL,
		  bedroom_id bigint(10) NOT NULL,
		  fecha DATE,
		  PRIMARY KEY (id),
		  CONSTRAINT fk_reservation FOREIGN KEY (id_reservation) REFERENCES $table_name1(id),
		  CONSTRAINT fk_bedroom FOREIGN KEY (bedroom_id) REFERENCES $table_name4(id)
		) $charset_collate;";

		$sql6 = "INSERT IGNORE INTO $table_name3 (id, email, email_address) VALUES(1, 'Plantilla de correo','fmanuelm2012@gmail.com') ON DUPLICATE KEY UPDATE email = 'Plantilla de correo', email_address = 'fmanuelm2012@gmail.com'";

		$sql7 = "INSERT IGNORE INTO $table_name5 (id, slug) VALUES(1, 'page') ON DUPLICATE KEY UPDATE slug = 'page'";

		/*
		room_name
		price
		status
		id_reservation
		*/
		
		dbDelta( $sql1 );
		dbDelta( $sql2 );
		dbDelta( $sql3 );
		dbDelta( $sql4 );
		dbDelta( $sql5 );
		dbDelta( $sql6 );
		dbDelta( $sql06 );
		dbDelta( $sql7 );
		add_option( 'form_mapelo_reservation_version', $form_mapelo_reservation_version );
	}
?>