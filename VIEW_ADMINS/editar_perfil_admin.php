<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
<?php
// Conexión con la base de datos
$nombreservidor = "localhost";
$nombreusuario = "root";
$password = "";
$basedatos = "prueba";

// Establecer conexión con la BD
$conn = new mysqli($nombreservidor, $nombreusuario, $password, $basedatos);

// Verificar si se ha enviado un ID de usuario y el campo a editar
if (isset($_GET['id']) && isset($_GET['campo'])) {
    $id_usuario = $_GET['id'];
    $campo_editar = $_GET['campo'];

    //Consulta SQL para obtener el user, password, email, nombre, apellido y fecha de nacimiento del usuario
    $query = "SELECT Usu_user, Usu_password, Usu_email, Usu_nombre, Usu_apellido, Usu_fechacumple FROM usuario WHERE Usu_ID = $id_usuario";
    $resultado = $conn->query($query);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
    }

    // Validar y procesar el campo a editar
    if ($campo_editar === 'Usu_user') {
        ?>
            <h1>Editar nombre de usuario</h1>
            <?php
            echo "<h2>Usuario actual: " . $row['Usu_user'] . "</h2>";
            ?>
            <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_user_admin.php?id=<?php echo $id_usuario ?>" method="POST">
                <label for="nuevo_usuario">Nombre de usuario nuevo</label>
                <input type="text" name="nuevo_usuario" required>
                <input type="submit" value="Guardar">
            </form>
            <a href="perfil_admin.php">Volver</a>
        <?php
    } elseif ($campo_editar === 'Usu_password') {
        ?>
            <h1>Editar contraseña</h1>
            <?php
            echo "<h2>Contraseña actual: " . $row['Usu_password'] . "</h2>";
            ?>
            <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_password_admin.php?id=<?php echo $id_usuario ?>" method="POST">
                <label for="nueva_password">Contraseña nueva</label>
                <input type="text" name="nueva_password" required>
                <input type="submit" value="Guardar">
            </form>
            <a href="perfil_admin.php">Volver</a>
        <?php
    } elseif ($campo_editar === 'Usu_email') {
        ?>
        <h1>Editar correo electrónico</h1>
        <?php
        echo "<h2>Correo actual: " . $row['Usu_email'] . "</h2>";
        ?>
        <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_email_admin.php?id=<?php echo $id_usuario ?>" method="POST">
            <label for="nuevo_email">Correo electrónico nuevo</label>
            <input type="text" name="nuevo_email" required>
            <input type="submit" value="Guardar">
        </form>
        <a href="perfil_admin.php">Volver</a>
        <?php
    } elseif ($campo_editar === 'Usu_nombre') {
        ?>
        <h1>Editar nombre</h1>
        <?php
        echo "<h2>Nombre actual: " . $row['Usu_nombre'] . "</h2>";
        ?>
        <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_nombre_admin.php?id=<?php echo $id_usuario ?>" method="POST">
            <label for="nuevo_nombre">Nombre nuevo:</label>
            <input type="text" name="nuevo_nombre" required>
            <input type="submit" value="Guardar">
        </form>
        <a href="perfil_admin.php">Volver</a>
        <?php
    } elseif ($campo_editar === 'Usu_apellido') {
        ?>
        <h1>Editar apellido</h1>
        <?php
        echo "<h2>Apellido actual: " . $row['Usu_apellido'] . "</h2>";
        ?>
        <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_apellido_admin.php?id=<?php echo $id_usuario ?>" method="POST">
            <label for="nuevo_apellido">Apellido nuevo</label>
            <input type="text" name="nuevo_apellido" required>
            <input type="submit" value="Guardar">
        </form>
        <a href="perfil_admin.php">Volver</a>
        <?php
    } elseif ($campo_editar === 'Usu_fechacumple') {
        ?>
        <h1>Editar fecha de creación</h1>
        <?php
        echo "<h2>Fecha actual: " . $row['Usu_fechacumple'] . "</h2>";
        ?>
        <form action="../VIEW_ADMINS../EDITAR_PERFIL_ADMIN/editar_fecha_admin.php?id=<?php echo $id_usuario ?>" method="POST">
            <label for="nueva_fecha">Fecha nueva</label>
            <input type="date" id="fecha" name="nueva_fecha">
            <input type="submit" value="Guardar">
        </form>
        <a href="perfil_admin.php">Volver</a>
        <?php
    } else {
        echo "Campo no válido para editar";
    }
} else {
    echo "Falta el ID de usuario o el campo a editar";
}
?>
</body>
</html>
