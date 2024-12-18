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
                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="Introduce tu correo" required>
            </div>
            <div class="input-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Introduce tu contraseña" required>
            </div>
            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>
        <div class="login-footer">
            <p>¿No tienes una cuenta? <a href="TABALAUSUARIO/RegisterUser.php">Regístrate aquí</a></p>
        </div>
    </div>
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
</body>
</html>
