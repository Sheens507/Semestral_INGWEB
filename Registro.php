<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="/Proyecto_web/styles/style_login.css">
</head>
<body>
<section>
    <div class="container">
        <div class="ribbon">
            <h2>Registro de Usuario</h2>
        </div>
        <div class="user">
            <div class="imgBx"><img src="/Proyecto_web/image/registro_imagen.jpg" width="100px" height="100px" alt=""></div>

            <div class="formBx">
                <form action="procesar_registro.php" method="post">
                    <div class="input-container">
                        <!-- Campos del formulario 1 -->
                        <label for="usuario">Nombre de Usuario:</label>
                        <input type="text" id="usuario" name="usuario" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->usuario : ''; ?>" required>

                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->password : ''; ?>" required>

                        <label for="correo">Correo Electrónico:</label>
                        <input type="text" id="correo" name="correo" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->correo : ''; ?>" required>

                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->nombre : ''; ?>" required>

                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->apellido : ''; ?>" required>

                        <label for="fecha">Fecha de nacimiento:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo isset($_COOKIE['datos_ultimo_ingreso']) ? json_decode($_COOKIE['datos_ultimo_ingreso'])->fecha : ''; ?>" required>
                    </div>

                    <input type="submit" value="Registrarse">
                    <p class="signup">¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>
