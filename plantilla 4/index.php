<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
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
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
    <!-- loader -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>
    <!-- end loader -->
    <header>
        <!-- header inner -->
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-3 col logo_section">
                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                    <a href="index.html"><img src="images/logo.png" alt="#" style="width: 150px; height: auto;" /></a>
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
                                        <a class="nav-link" href="index.php">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="about.php">Acerca</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="valores.php">Valores</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="productos.php">Productos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="proceso.php">Proceso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contactanos.php">Contactanos</a>
                                    </li>
                                </ul>
                                <div class="navbar-icons">
                                    <?php if (isset($_SESSION['usuario'])): ?>
                                        <span class="nav-link" style="color: rgb(10, 10, 10);" title="Usuario"><?php echo $_SESSION['usuario']; ?></span>
                                        <a class="nav-link" href="logout.php" style="color: rgb(10, 10, 10);" title="Cerrar Sesión">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        </a>
                                        <?php if ($_SESSION['is_admin']): ?>
                                            <a class="nav-link" href="TABLAPRODUCTOS/RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </a>
                                            <a class="nav-link" href="TABLAPRODUCTOS/MostrarProductosEliminar.php" style="color: rgb(8, 8, 8);" title="Eliminar Producto">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a class="nav-link" href="Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a class="nav-link" href="TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
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
     
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row">
                           <div class="col-md-7 offset-md-5">
                              <div class="text-bg">
                                 <h1> Innovación<br> en relleno para embalajes </h1>
                                 <span>Existen muchas alternativas ecológicas para proteger tus productos de forma segura.</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row">
                           <div class="col-md-7 offset-md-5">
                              <div class="text-bg">
                                 <h1> Innovamos<br> en Protección de Productos</h1>
                                 <span>Transformamos la forma en que embalas tus productos con soluciones innovadoras.</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <div class="row">
                           <div class="col-md-7 offset-md-5">
                              <div class="text-bg">
                                 <h1> Comprometidos<br> con el Medio Ambiente</h1>
                                 <span>Utilizamos materiales sostenibles para reducir nuestro impacto ecológico.</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
            </a>
         </div>
      </section>
      <!-- end banner -->

      <!-- about -->
      <div id="about" class="about">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>Sobre <span class="green">Nosotros</span></h2>
                     <p>Somos una empresa dedicada a la fabricación de soluciones de embalaje sostenibles y respetuosas con el medio ambiente. Nuestros productos, como los rellenos biodegradables para cajas de paquetes, están diseñados para proteger tus envíos mientras reducimos el impacto ambiental. Innovamos en cada proceso para ofrecerte la mejor opción en embalajes ecológicos y eficientes.</p>

                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="images/about.png" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->

      <!-- Mision -->
      <div id="Mision" class="mision">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>Nuestra <span class="green">Mision</span></h2>
                     <p>Producir embalajes ecológicos de alta calidad y asequibles, diseñados para minimizar el impacto ambiental, utilizando procesos sostenibles. Nos comprometemos a innovar continuamente para ofrecer soluciones eficientes de embalaje que sean seguras para el planeta.</p>

                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="images/mision.jpg" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end mision -->

      <!-- VISION -->

      <div id="Mision" class="mision">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>Nuestra <span class="green">Vision</span></h2>
                     <p>Posicionarnos como lideres nacionales en la creación de embalajes ecológicos accesibles, que contribuyan a un futuro más limpio y sostenible.</p>

                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="images/vision.png" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- end VISION -->
      
      <!--  Valores -->
      <div id="valores" class="service">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Nuestros <span class="green">Valores</span></h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <div class="row">
                     <div class="col-md-4 col-sm-6">
                        <div class="service_box">
                           <i><img src="images/sostenibilidadd.jpg" alt="Sostenibilidad" class="service-img"/></i>
                           <h3>Sostenibilidad</h3>
                           <p>Nos dedicamos a proteger el medio ambiente mediante el uso de biomasa como materia prima.</p>
                        </div>
                     </div>
                     <div class="col-md-4 offset-md-1 col-sm-6">
                        <div class="service_box">
                           <i><img src="images/enfoque.jpg" alt="Enfoque en Clientes" class="service-img"/></i>
                           <h3>Enfoque en Clientes</h3>
                           <p>Creando una relación cercana con los clientes para entender sus desafíos y brindarles soluciones eficientes.</p>
                        </div>
                     </div>
                     <div class="col-md-4 offset-md-3 col-sm-6 mar_top">
                        <div class="service_box">
                           <i><img src="images/inovacion.jpg" alt="Innovación" class="service-img"/></i>
                           <h3>Innovación</h3>
                           <p>Investigando y adoptando nuevas tecnologías y modelos de negocio para asegurar embalajes ecológicos y eficientes.</p>
                        </div>
                     </div>
                     <div class="col-md-4 offset-md-1 col-sm-6 mar_top">
                        <div class="service_box">
                           <i><img src="images/calidad.jpg" alt="Calidad" class="service-img"/></i>
                           <h3>Calidad</h3>
                           <p>Comprometidos a ofrecer embalajes que cumplen con altos estándares de durabilidad y seguridad.</p>
                        </div>
                     </div>
                     <div class="col-md-12">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end valores -->


      <!-- productos -->
      <div id="productos"  class="gallery">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Nuestros <span class="green">Productos</span></h2>
                     <p>Ofrecemos chetos de embalaje ecológicos, ideales para proteger tus envíos.</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_text">
                     <div class="galleryh3">
                        <h3>Diseño de Embalaje</h3>
                        <p>Los chetos de embalaje protegen tus productos. <br>
                           Hechos de materiales reciclables, <br>
                           son una opción ecológica <br>
                           y efectiva.
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery1.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery2.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery3.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery4.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_text">
                     <div class="galleryh3">
                        <h3>Diseño de Embalaje</h3>
                        <p>Los chetos de embalaje protegen tus productos. <br>
                           Hechos de materiales reciclables, <br>
                           son una opción ecológica <br>
                           y efectiva.
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_text">
                     <div class="galleryh3">
                        <h3>Diseño de Embalaje</h3>
                        <p>Los chetos de embalaje protegen tus productos. <br>
                           Hechos de materiales reciclables, <br>
                           son una opción ecológica <br>
                           y efectiva.
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery5.jpeg" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="images/gallery6.jpeg" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end gallery -->
       
      <!-- video -->
<div class="design">
   <div class="container-fluid">
      <div class="row d_flex">
         <div class="col-md-5">
            <div id="design" class="carousel slide banner_design" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#design" data-slide-to="0" class="active"></li>
                  <li data-target="#design" data-slide-to="1"></li>
                  <li data-target="#design" data-slide-to="2"></li>
               </ol>
               <div class="carousel-inner">
                  <div class="carousel-item active">
                      <div class="container">
                          <div class="carousel-caption relative">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="text_de">
                                          <div class="titlepage">
                                              <h2>Chetos de <span class="green">Embalaje</span></h2>
                                          </div>
                                          <p>Los chetos de embalaje son una solución ecológica para proteger tus productos durante el envío, asegurando que lleguen en perfectas condiciones.</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <div class="container">
                          <div class="carousel-caption relative">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="text_de">
                                          <div class="titlepage">
                                              <h2>Protección <span class="green">Sostenible</span></h2>
                                          </div>
                                          <p>Nuestros chetos de embalaje están hechos de materiales reciclables, reduciendo el impacto ambiental y promoviendo la sostenibilidad.</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <div class="container">
                          <div class="carousel-caption relative">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="text_de">
                                          <div class="titlepage">
                                              <h2>Innovación en <span class="green">Embalaje</span></h2>
                                          </div>
                                          <p>Descubre cómo nuestros chetos de embalaje están revolucionando la industria, ofreciendo una alternativa ligera y efectiva para el transporte seguro de productos.</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              
               <a class="carousel-control-prev" href="#design" role="button" data-slide="prev">
               <i class="fa fa-angle-left" aria-hidden="true"></i>
               <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#design" role="button" data-slide="next">
               <i class="fa fa-angle-right" aria-hidden="true"></i>
               <span class="sr-only">Next</span>
               </a>
            </div>
         </div>
         <div class="col-md-7 pad_roght0">
            <div class="design_video">
               <figure>
                  <video class="custom-video" autoplay muted loop playsinline>
                     <source src="images/videoChetos.mp4" type="video/mp4">
                     Tu navegador no soporta videos HTML5.
                  </video>
               </figure>
            </div>
         </div>
         </div>
      </div>
   </div>
</div>
      <!-- end video -->

   <!-- Diagrama -->
<div class="process-presentation">
   <!-- Contenedor de navegación -->
   <div class="navigation">
       <button id="prev-btn">← Anterior</button>
       <button id="next-btn">Siguiente →</button>
   </div>

   <div class="progress-bar">
      <div class="progress"></div>
  </div>

   <!-- Sección INICIO del diagrama -->
   <div class="diagram-section active" id="section-1">
       <h3>PROCESO DE ELABORACION.</h3>
       <img src="images/Diagrama Completo.jpeg" alt="Paso 1 del proceso">
   </div>

   <!-- Sección 1 del diagrama -->
   <div class="diagram-section" id="section-2">
       <h3>Paso 1: RECOLECCION.</h3>
       <img src="images/PASO1.jpeg" alt="Paso 2 del proceso">
   </div>

   <!-- Sección 2 del diagrama -->
   <div class="diagram-section" id="section-3">
       <h3>Paso 2; TRANSPORTE.</h3>
       <img src="images/PASO2.jpeg" alt="Paso 3 del proceso">
   </div>

   <!-- Sección 3 del diagrama -->
   <div class="diagram-section" id="section-4">
      <h3>Paso 3: LIMPIEZA Y SELECCION.</h3>
      <img src="images/PASO3.jpeg" alt="Paso 6 del proceso">
   </div>

   <!-- Sección 4 del diagrama -->
   <div class="diagram-section" id="section-5">
       <h3>Paso 4: TRATAMIENTO TERMICO.</h3>
       <img src="images/PASO4.jpeg" alt="Paso 7 y 8 del proceso">
   </div>

   <!-- Sección 5 del diagrama -->
   <div class="diagram-section" id="section-6">
       <h3>Paso 5: TRATAMIENTO QUIMICO.</h3>
       <img src="images/PASO5.jpeg" alt="Paso 9 y 10 del proceso">
   </div>

   <!-- Sección 6 del diagrama -->
   <div class="diagram-section" id="section-7">
      <h3>Paso 6: PROCESO DE TRITURACION.</h3>
      <img src="images/PASO6.jpeg" alt="Paso 9 y 10 del proceso">
  </div>

   <!-- Sección 7 del diagrama -->
   <div class="diagram-section" id="section-8">
      <h3>Paso PASO 7: VERTIDO EN MOLDES.</h3>
      <img src="images/PASO7.jpeg" alt="Paso 9 y 10 del proceso">
   </div>

   <!-- Sección 8 del diagrama -->
   <div class="diagram-section" id="section-9">
      <h3>Paso 8: SECADO AL SOL.</h3>
      <img src="images/PASO8.jpeg" alt="Paso 9 y 10 del proceso">
   </div>

   <!-- Sección 9 del diagrama -->
   <div class="diagram-section" id="section-10">
      <h3>Paso 9: DESMOLDE.</h3>
      <img src="images/PASO9.jpeg" alt="Paso 9 y 10 del proceso">
   </div>

   <!-- Sección 10 del diagrama -->
   <div class="diagram-section" id="section-11">
      <h3>Paso 10: EMPAQUETADO.</h3>
      <img src="images/PASO10.jpeg" alt="Paso 9 y 10 del proceso">
   </div>

</div>
     
      <!-- Fin del diagrama -->

      <!--  contact -->
      <div id="contact" class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Contactanos</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
               <form id="request" class="main_form" action="contact.php" method="post"> <div class="row"> <div class="col-md-12"> <input class="contactus" placeholder="Name" type="text" name="Name" required> </div> <div class="col-md-12"> <input class="contactus" placeholder="Email" type="email" name="Email" required> </div> <div class="col-md-12"> <input class="contactus" placeholder="PhoneNumber" type="text" name="PhoneNumber" required> </div> <div class="col-md-12"> <textarea class="textarea" placeholder="Message" name="Message" required></textarea> </div> <!-- Aquí se añade el widget de reCAPTCHA v2 --> <div class="g-recaptcha" data-sitekey="6LdKw24qAAAAABt4LYArbCF51JRqTiIMsCRBOLs0"></div> <div class="col-md-12"> <button type="submit" class="send_btn">Send</button> </div> </div> </form>
               </div>
               <div class="col-md-6">
                  <div class="map_main">
                      <div class="map-responsive">
                          <iframe
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3621.8576333274563!2d-101.40644448497866!3d26.944872824155234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x868bcc4cd0bb8763%3A0xa202c7d8d49db8c2!2sTecNM%20-%20Campus%20Monclova!5e0!3m2!1ses!2smx!4v1631572294016!5m2!1ses!2smx"
                          width="600"
                          height="345"
                          style="border:0; width: 100%;"
                          allowfullscreen=""
                          loading="lazy">
                          </iframe>
                      </div>
                  </div>
              </div>
            </div>
         </div>
      </div>
      <!-- end contact -->

      <!--  Fin de pagina -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-3 col-sm-6">
                     <ul class="social_icon">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.instagram.com/rizomatss?igsh=MThtdG54ZWNwdXBpMg==" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                     </ul>
                     <p class="variat pad_roght2">Nuestros chetos de embalaje son una solución ecológica, ideales para proteger tus productos durante el envío.</p>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <h3>TE AYUDAMOS?</h3>
                     <p class="variat pad_roght2">Ofrecemos soluciones de embalaje que cuidan el medio ambiente y aseguran la integridad de tus envíos.</p>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <h3>INFORMACIÓN</h3>
                     <ul class="link_menu">
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="about.html">Acerca de</a></li>
                        <li><a href="service.html">Servicios</a></li>
                        <li><a href="gallery.html">Galería</a></li>
                        <li><a href="testimonial.html">Testimonios</a></li>
                        <li><a href="contact.html">Contáctanos</a></li>
                     </ul>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <h3>NUESTRO Diseño</h3>
                     <p class="variat">Cuidamos del planeta con productos de embalaje sostenibles y eficaces.</p>
                  </div>
                  
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-10 offset-md-1">
                        <p>© 2024 Todos los derechos reservados. Rizomat
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->

      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>

   

   <script>
      let currentSection = 1; // Iniciamos en la sección 1
      const totalSections = document.querySelectorAll('.diagram-section').length; // Número total de secciones
      let isTransitioning = false; // Nueva variable para evitar clicks rápidos
  
      function updateProgressBar() {
          const progress = document.querySelector('.progress');
          progress.style.width = `calc(100% / ${totalSections} * ${currentSection})`;
      }
  
      function changeSection(next) {
          if (isTransitioning) return; // Evitar que la función se ejecute durante una transición
          isTransitioning = true; // Bloqueamos más clicks
  
          const currentElem = document.getElementById(`section-${currentSection}`);
          currentElem.classList.remove('active');
  
          setTimeout(() => {
              currentElem.style.display = 'none'; // Ocultamos la sección actual
              if (next) {
                  currentSection++;
              } else {
                  currentSection--;
              }
              const newElem = document.getElementById(`section-${currentSection}`);
              newElem.style.display = 'block'; // Mostramos la nueva sección
              setTimeout(() => {
                  newElem.classList.add('active'); // Activamos la nueva sección
                  isTransitioning = false; // Desbloqueamos los clicks
              }, 50);
  
              updateProgressBar(); // Actualizamos la barra de progreso
          }, 300); // Sincronizamos con el tiempo de la animación
      }
  
      document.getElementById('next-btn').addEventListener('click', () => {
          if (currentSection < totalSections) {
              changeSection(true);
          }
      });
  
      document.getElementById('prev-btn').addEventListener('click', () => {
          if (currentSection > 1) {
              changeSection(false);
          }
      });
  </script>
  
</html>