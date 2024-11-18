<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Asegúrate de incluir el enlace a Font Awesome en tu archivo HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Rizomat</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }

    </style>
</head>
<body>
   

<header>
        <!-- header inner -->
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
                                        <a class="nav-link" href="../index.php">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../about.php">Acerca</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../valores.php">Valores</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../productos.php">Productos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../proceso.php">Proceso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../contactanos.php">Contactanos</a>
                                    </li>
                                </ul>
                                <div class="navbar-icons">
                                    <?php if (isset($_SESSION['usuario'])): ?>
                                        <span class="nav-link" style="color: rgb(10, 10, 10);" title="Usuario"><?php echo $_SESSION['usuario']; ?></span>
                                        <a class="nav-link" href="../logout.php" style="color: rgb(10, 10, 10);" title="Cerrar Sesión">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        </a>
                                        <?php if ($_SESSION['is_admin']): ?>
                                            <a class="nav-link" href="../TABLAPRODUCTOS/RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </a>
                                            <a class="nav-link" href="../TABLAPRODUCTOS/MostrarProductosEliminar.php" style="color: rgb(8, 8, 8);" title="Eliminar Producto">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a class="nav-link" href="Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a class="nav-link" href="/web/plantilla%204/TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
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
