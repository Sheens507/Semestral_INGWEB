<?php
session_start();

	//Obtiene el nombre de usuario de la sesión
	if (isset($_SESSION['usuario'])) {
		$username = $_SESSION['usuario'];
	
		//Obtiene el nombre de la canción desde el form
		$song = $_POST['nombre'];
	
		//Establece el nombre de la canción con el usuario
		$cookieName = "ultima_cancion_" . $username;
	
		
		if (!empty($song)) {
			setcookie($cookieName, $song, time() + (86400 * 1), "/");
		}

	$curl = curl_init();
	$url = "https://genius-song-lyrics1.p.rapidapi.com/search/?q=" . urlencode($song) . "&per_page=6&page=1";
	curl_setopt_array($curl, [
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: genius-song-lyrics1.p.rapidapi.com",
			"X-RapidAPI-Key: 5ab8f2c36amshc6d09b3d9de7172p1ac2c9jsn1b2fca3fdb3b"
		],
	]);
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		include('../VIEW_ADMINS/Display_info_admin.php');
		processApiResponse($response);

		 //Llamada al procedimiento Insertar_busqueda
		 $conexion = new mysqli("localhost", "root", "", "prueba");
		 if ($conexion->connect_error) {
			 die("Error en la conexión: " . $conexion->connect_error);
		 }
 
		 $nombre_cancion = $song;
		 $query = "CALL Insertar_busqueda('$nombre_cancion')";
		 $conexion->query($query);
 
		 $conexion->close();
	}
	} else {
		// Redirigir si el usuario no está autenticado
		header("Location: index.php");
		exit();
	}
