<!-- Esta es lo que ve una peronsa general-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../image/icon.png" alt="logo">
        </div>
        <nav>
            <ul>
                <li><a href="Login.php">Login</a></li>
                <li><a href="Registro.php">Sign Up</a></li>
            </ul>
        </nav>
    </header>
    <form action="API_canciones/call_api.php" method="post" onsubmit="transformAndSubmit()">
        <input type="text" name="nombre" id="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
        <input type="submit" value="Enviar"><br><br>
    </form>

</body>
</html>

