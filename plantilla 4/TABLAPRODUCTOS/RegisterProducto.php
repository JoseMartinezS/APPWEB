<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Producto</title>
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
                                <a href="index.html"><img src="../images/logo.png" alt="#" style="width: 150px; height: auto;" /></a>
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
                                <a class="nav-link" href="RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
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
            <div class="col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Registro de Producto</h3>

                        <form action="InsertarDatos.php" method="POST" enctype="multipart/form-data">
                            <div class="form-outline mb-4">
                                <input type="text" name="nombre" id="nombre" class="form-control" required />
                                <label class="form-label" for="nombre">Nombre del Producto</label>
                            </div>

                            <div class="form-outline mb-4">
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required></textarea>
                                <label class="form-label" for="descripcion">Descripción</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required />
                                <label class="form-label" for="precio">Precio</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" name="stock" id="stock" class="form-control" required />
                                <label class="form-label" for="stock">Stock</label>
                            </div>

                            <div class="form-outline mb-4">
                            <input type="number" step="0.01" name="peso" id="peso" class="form-control" required />
                            <label class="form-label" for="peso">Peso(KG)</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" />
                                <label class="form-label" for="imagen">Imagen del Producto</label>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg mb-1">Registrar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
