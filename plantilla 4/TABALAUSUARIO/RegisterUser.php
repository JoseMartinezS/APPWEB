<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f9e6; /* Color verde claro */
            font-family: 'Arial', sans-serif; /* Fuente más amigable */
        }

        .h-custom {
            height: 100vh !important;
        }

        .card {
            background-color: #ffffff; /* Fondo blanco */
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #4caf50; /* Verde más oscuro */
            border: none;
        }

        .form-label {
            color: #4caf50; /* Color verde */
        }

        .form-control {
            border: 2px solid #4caf50; /* Bordes verdes */
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #81c784; /* Verde más claro en el foco */
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        h3 {
            color: #2e7d32; /* Verde más oscuro para el título */
        }
    </style>
</head>
<body>
<section class="h-100 h-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Registro de Usuario</h3>

                        <form action="InsertarDatos.php" method="POST">

                            <div class="form-outline mb-4">
                                <input type="text" name="nombre" id="nombre" class="form-control" required />
                                <label class="form-label" for="nombre">Nombre</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" name="correo" id="correo" class="form-control" required />
                                <label class="form-label" for="correo">Correo Electrónico</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="tel" name="telefono" id="telefono" class="form-control" required />
                                <label class="form-label" for="telefono">Teléfono</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" name="direccion" id="direccion" class="form-control" required />
                                <label class="form-label" for="direccion">Dirección</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required />
                                <label class="form-label" for="contrasena">Contraseña</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" name="confirm_contrasena" id="confirm_contrasena" class="form-control" required />
                                <label class="form-label" for="confirm_contrasena">Confirmar Contraseña</label>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg mb-1">Registrar</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
