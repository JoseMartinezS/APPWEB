<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Conexión al archivo CSS -->
</head>


<body>

    <!-- Incluir el header -->
    <?php include 'header.php'; ?>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="Introduce tu correo" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>
            </div>
            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>
        <div class="login-footer">
            <p>¿No tienes una cuenta? <a href="TABALAUSUARIO/RegisterUser.php">Regístrate aquí</a></p>
        </div>
    </div>

</body>
</html>
