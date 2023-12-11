<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRADOR</title>
</head>
<body>

    <form action="../VIEW_ADMINS/all_users.php" method="post">
        <button type="submit" name="mostrarTodos">Mostrar Todos los Usuarios</button>
    </form> <br>
    <form action="../VIEW_ADMINS/all_favoritos.php" method="post">
        <button type="submit" name="mostrarFavoritos">Mostrar Todos los Favoritos</button>
    </form> <br>
    <a href="index_admin.php">Volver a Home</a>
</body>
</html>
