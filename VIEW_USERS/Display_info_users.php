<?php

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit(); 
}
$username = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
?>

<?php
    function processApiResponse($response) {
        $data = json_decode($response, true);
        $count = 0;
    
        echo '<div class="canciones">';
    
        foreach ($data['hits'] as $hit) {
            $result = $hit['result'];
            $id = $result['id'];
            $title_with_featured = $result['title_with_featured'];
            $header_image_url = $result['header_image_url'];
            $primary_artist_name = $result['primary_artist']['name'];
    
            echo '<div class="cancion">';
            echo '<div class="container">';
            echo '<img src="' . $header_image_url . '" alt="Banner ' . $title_with_featured . '">';
    
            echo '<div class="contenido">';
            echo '<div class="info">';
            echo '<h2>' . $title_with_featured . '</h2>';
            echo '<p><b>Artist:</b> ' . $primary_artist_name . '</p>';
    
            if (isset($result['featured_artists']) && is_array($result['featured_artists'])) {
                echo '<p><b>Featured Artists:</b> ';
                $featuredArtists = array_map(function ($artist) {
                    return $artist['name'];
                }, $result['featured_artists']);
                echo implode(', ', $featuredArtists) . '</p>';
            } else {
                echo "<p><b>Featured Artists:</b> null</p>";
            }
    
            echo '</div>'; // Cierre de div.info
            echo '</div>'; // Cierre de div.contenido
    
            echo '<div class="botones">';
            echo '<form action="../API letras/call_api_letra_user.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">Lyrics</button>';
            echo '</form>';
            echo '</div>'; // Cierre de div.botones
    
            echo '<div class="botones">';
            echo '<form action="../VIEW_USERS/guardar_favorito.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="imagen_cancion" value="' . $header_image_url . ' ">';
            echo '<input type="hidden" name="nombre_cancion" value="' . $title_with_featured . '">';
            echo '<input type="hidden" name="nombre_artista" value="' . $primary_artist_name . '">';
            echo '<button type="submit">Favoritos</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
    
            $count++;
        }
    
        echo '</div>'; // Cierre de div.canciones
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canciones</title>
    <link href="../styles/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    margin: 0;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #ffffff;
    color: #000000;
}

nav ul {
    list-style: none;
    display: flex;
}

nav ul li {
    margin-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: #000000;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 1px;
    transition: 0.5s;
}

.cuenta {
    display: flex;
    align-items: center;
}

.cuenta img {
    width: 35px;
    height: auto;
    margin-left: 10px;
}

.personal_info {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
}

nav ul li a.btn-login {
    background-color: #2a2a2a;
    color: #fff;
    padding: 10px 20px;
    border-radius: 30px;
    transition: 0.5s;
}

nav ul li a.btn-login:hover {
    background-color: #1c1c1c;
}

.logo img {
    width: 30%;
}

/* Estilos para las canciones */
.canciones {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Espacio entre las canciones */
}

/* Estilos para cada canción */
.cancion {
    width: calc(33.33% - 20px); /* Ancho del 33.33% menos el espacio entre ellas */
    margin-bottom: 20px; /* Espacio entre las filas */
}

.container {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 90%; /* Reduzco el ancho del contenedor */
    margin: 0 auto; /* Centro el contenedor en la página */
}

.container img {
    width: 90%;
    height: auto;
    margin-left:20px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    margin-top: 10px;
}

.contenido {
    padding: 15px;
}

.info h2 {
    margin-top: 0;
}

.info p {
    margin-bottom: 5px;
}

.botones {
    text-align: center;
    margin-top: 10px;
    margin-bottom: 5px;
}

.botones button {
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.botones button:hover {
    background-color: #0056b3;
}




nav {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    color: #004080;
    margin-top: 20px;
    margin-right: 20px; /* Ajusta el margen derecho según tus preferencias */
}

nav form {
    display: flex;
    align-items: center;
}

nav input[type="text"] {
    padding: 10px;
    border: none;
    border-radius: 5px;
    margin-right: 19px; /* Ajusta el margen derecho según tus preferencias */
}

nav input[type="submit"] {
    padding: 10px 16px;
    background-color: #0056b3;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

nav input[type="submit"]:hover {
    background-color: #004080; /* Cambia el color al pasar el ratón por encima */
}


.cuenta {
    display: flex;
    align-items: center;
}

.cuenta img {
    width: 48px;
    height: 50px;
    margin-left: 10px;
}

.personal_info {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
}
form.logout-form {
        margin: 0;
        padding: 0;
            display: flex;
            align-items: center;
        margin-top: -20px;
        }

        form.logout-form button {
            background: #007bff url('/Proyecto_web/icons/css.gg/icons/png/black/log-out.png') no-repeat center left; /* Ruta a tu icono */
            background-size: 20px 20px; /* Ajusta el tamaño del icono según tus preferencias */
            border: none;
            cursor: pointer;
            color: #000000;
            font-weight: 600;
            padding: 8px 40px 8px 20px; /* Ajusta el relleno según tus preferencias */
            margin-left: 10px; /* Ajusta el margen según tus preferencias */
            border-radius: 4px;
            transition: background 0.3s;
        }

        form.logout-form button:hover {
            background: #0056b3 url('/Proyecto_web/icons/css.gg/icons/png/black/log-out.png') no-repeat center left; /* Cambia el color de fondo en hover */
            background-size: 20px 20px; /* Ajusta el tamaño del icono en hover */
            text-decoration: none;
        }
        .back-to-home-btn {
            background-color: rgba(138, 166, 179, 0.7);
            color: #fff;
            padding: 10px 10px;
            border-radius: 30px;
            transition: 0.5s;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }

        .back-to-home-btn:hover {
            background-color: #1c1c1c;
        }

        /* Estilos para la barra de búsqueda */
        .option-container {
        background-color: #27323D; /* o cualquier otro color para identificar su posición */
        height: 70px;
        color: #000000;
        position: relative;
            z-index: 1; /* Asegura que .option-container esté por encima del contenido del body */
        }

        .search-box {
            display: flex;
            align-items: center;
            margin-top: -80px;
        }


        .input-search {
            height: 10px;
            width: 20px;
            border-style: none;
            padding: 10px 10px;
            font-size: 18px;
            letter-spacing: 2px;
            outline: none;
            border-radius: 25px;
            transition: all .5s ease-in-out;
            background-color: rgba(138, 166, 179, 0.7); /* Cambia el valor de rgba para ajustar la opacidad */
            padding-right: 40px;
            color: #fff;
            margin-right: 10px; /* Espaciado entre el ícono y el input */
        }

        .input-search::placeholder {
            color: rgba(255, 255, 255, .5);
            font-size: 18px;
            letter-spacing: 2px;
            font-weight: 100;
        }

        .btn-search {
            width: 30px;
            height: 30px;
            border-style: none;
            font-size: 20px;
            font-weight: bold;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
            color: #ffffff;
            background-color: transparent;
            pointer-events: painted;
            margin-right: 30px;
        }

        .btn-search:focus~.input-search {
            width: 300px;
            border-radius: 0px;
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, .5);
            transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
        }

        .input-search:focus {
            width: 300px;
            border-radius: 0px;
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, .5);
            transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
        }

        form.search-form {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            color: #000000;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #000000;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            transition: 0.5s;
        }

        .cuenta {
            display: flex;
            align-items: center;
        }

        .cuenta img {
            width: 48px;
            height: 50px;
            margin-left: 10px;
        }

        .personal_info {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        nav ul li a.btn-login {
            background-color: #2a2a2a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 30px;
            transition: 0.5s;
        }

        nav ul li a.btn-login:hover {
            background-color: #1c1c1c;
        }
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        td img {
            width: 50%;
            heigth: auto;
        }
        form.logout-form {
        margin: 0;
        padding: 0;
            display: flex;
            align-items: center;
        margin-top: -20px;
        }

        form.logout-form button {
            background: #007bff url('/Proyecto_web/icons/css.gg/icons/png/black/log-out.png') no-repeat center left; /* Ruta a tu icono */
            background-size: 20px 20px; /* Ajusta el tamaño del icono según tus preferencias */
            border: none;
            cursor: pointer;
            color: #000000;
            font-weight: 600;
            padding: 8px 40px 8px 20px; /* Ajusta el relleno según tus preferencias */
            margin-left: 10px; /* Ajusta el margen según tus preferencias */
            border-radius: 4px;
            transition: background 0.3s;
        }

        form.logout-form button:hover {
            background: #0056b3 url('/Proyecto_web/icons/css.gg/icons/png/black/log-out.png') no-repeat center left; /* Cambia el color de fondo en hover */
            background-size: 20px 20px; /* Ajusta el tamaño del icono en hover */
            text-decoration: none;
        }
        
        h1{
            margin-left:30px;

        }

        .back-to-home-btn img {
    width: 20px; /* Ajusta el ancho de la flecha */
    height: 20px; /* Ajusta la altura de la flecha */
    margin-right: 5px; /* Ajusta el espacio entre la flecha y el texto */
}

footer {
            background: linear-gradient(230deg, #9ADEF5, #007bff);
            color: #000000;
            text-align: left;
            padding: 10px; /* Ajusta el padding según tus preferencias */
            display: cover;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }


        h5{
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 20px;
            text-align: left;
            margin-bottom: -5px;
        }


        h4{
            margin-left: 30px;
        }
        footer .column-container {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: space-between;
            margin-top: 1px;
            align-items: left;
        }

        /* Estilo para cada columna */
        footer .column {
            flex: 1; /* Usamos flex: 1 para que ocupen todo el espacio disponible */
            text-align: left;
            background: transparent;
            margin-bottom: 20px;
        }

            .footer .column:last-child {
        margin-bottom: 0;
        }
        footer .column img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
            margin-right:-20px;
        }

        /* Estilo para el contenido dentro de cada columna */
        footer .column p {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            font-size: 12px;
        }

        footer .column h5 {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-bottom: 10px;
        }
</style>
</head>
<header class="header-container">
    <div class="logo">
        <a href="../VIEW_USERS/index_users.php">
            <img src="../image/icon.png" alt="logo">
        </a>
    </div>
        <nav>
            <ul>
                <li><a href="../VIEW_USERS/favoritos_user.php"> Mis Favoritos</a></li>
            </ul>
        </nav>
        <div class="cuenta">
            <a href="../VIEW_USERS/perfil_user.php">
            <img src="/Proyecto_web/icons/css.gg/icons/png/white/arrow-long-left.png" alt="Volver atrás">
            </a>
            <div class="personal_info">
                ¡Hola <?php echo $username; ?>!<br><br>
                <form action="../cerrar_sesion.php" method="post" class="logout-form">
                <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
            </form>
            </div>
        </div>
    </header>
<body>
<div class="option-container">
        <!-- Utilizamos JavaScript para llamar a la función history.back() -->
        <a href="javascript:history.back()" class="back-to-home-btn">
        <img src="/Proyecto_web/icons/css.gg/icons/png/white/arrow-long-left.png" alt="Volver atrás">
            Volver atrás
        </a>
        <form action="../API_canciones/call_api_user.php" method="post" class="search-form">
            <div class="search-box">
                <input type="text" name="nombre" id="nombre" class="input-search" placeholder="Buscar canción">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    <h1>Resultados:</h1>
        <div class="contenido">
        <div class="display">
        <?php
            processApiResponse($response);
        ?>
        </div>
    </div>
    <a href="../VIEW_USERS/index_users.php">Volver</a>
    <footer>
        <div class="column-container">
            <div class="column">
                <h5>Albáez, Gabriela</h5>
                <p>8-983-1051</p>
                <p>gabriela.albaez@utp.ac.pa</p>
            </div>
            <div class="column">
                <h5>Romero, Martin</h5>
                <p>8-985-772</p>
                <p>martin.romero@utp.ac.pa</p>
            </div>
            <div class="column">
                <h5>Trelles, Andrés</h5>
                <p>8-971-969</p>
                <p>andres.trelles@utp.ac.pa</p>
            </div>
            <div class="column">
                <h5>Valoy, Britney</h5>
                <p>8-998-213</p>
                <p>britney.valoy@utp.ac.pa</p>
            </div>
        </div>
    </footer>
</body>
</html>
<!--