<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" type="text/css" href="/Proyecto_web/styles/style_login.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="ribbon">
                <h2>Iniciar Sesión</h2>
            </div>
            <div class="user singinBx">
                <div class="imgBx"><img src="/Proyecto_web/image/login-img.jpg" alt="Login Image"></div>
                <div class="formBx">
                    <form action="procesar_login.php" method="POST" enctype="multipart/form-data">
                        <h2>Ingresar</h2>
                        <div class="input-container">
                            <input type="text" name="usuario" placeholder="Usuario">
                        </div>
                        <div class="input-container">
                            <input type="password" name="password" placeholder="Contraseña">
                        </div>
                        <input type="Submit" name="login" value="Ingresar">
                        <p class="signup">¿No tienes cuenta? <a href="Registro.php">Regístrate</a></p>                        
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
