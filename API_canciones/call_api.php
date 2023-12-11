<?php
	$song = $_POST['nombre'];
	$curl = curl_init();
	// Concatenar la variable $song a la URL
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
		// Incluye el archivo con la función
		include('../Display_info.php');
		
		// Llama a la función para procesar la respuesta
		processApiResponse($response);
	}
