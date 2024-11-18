<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="icon" href="../images/fevicon.png" type="image/gif" />
    <style>
        body {
            background-color: #e6f9e6;
            font-family: 'Arial', sans-serif;
        }

        .h-custom {
            height: 100vh !important;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px; /* Reducir padding */
        }

        .form-label {
            color: #000000;
        }

        .form-control {
            border: 2px solid #999999;
            transition: border-color 0.3s;
            height: 40px; /* Reducir altura de los inputs */
            padding: 5px; /* Reducir padding interno */
        }

        .form-control:focus {
            border-color: #666666;
            box-shadow: 0 0 5px rgba(102, 102, 102, 0.5);
        }

        h3 {
            color: #333333;
            font-size: 24px; /* Reducir tamaño del título */
        }

        .form-group {
            margin-bottom: 15px; /* Reducir el margen entre campos */
        }

        .btn-primary {
            width: 100%; /* Botón ocupa todo el ancho */
        }
    </style>
</head>
<body>
<header>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.html"><img src="../images/logo.png" alt="#" style="width: 300px; height: auto;" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1">
                    <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="service.html">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="gallery.html">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#testimonial">Testimonial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary" href="test.php">Contact Us</a>
                                </li>
                            </ul>
                            <div class="navbar-icons">
                                <a class="nav-link" href="../Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" href="../TABLAPRODUCTOS/RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" href="../TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="h-100 h-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-6 col-xl-5">
                <div class="card rounded-3">
                    <div class="card-body p-4 p-md-3">
                        <h3 class="mb-3 pb-2">Registro de Usuario</h3>

                        <form action="InsertarDatos.php" method="POST">
                            <div class="form-group">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="correo">Correo Electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input type="tel" name="telefono" id="telefono" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="direccion">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required />
                            </div>

                            <!-- Agrupar contraseñas para hacer el formulario más compacto -->
                            <div class="form-group row">
                                <div class="col">
                                    <label class="form-label" for="contrasena">Contraseña</label>
                                    <input type="password" name="contrasena" id="contrasena" class="form-control" required />
                                </div>
                                <div class="col">
                                    <label class="form-label" for="confirm_contrasena">Confirmar</label>
                                    <input type="password" name="confirm_contrasena" id="confirm_contrasena" class="form-control" required />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg mt-3">Registrar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
