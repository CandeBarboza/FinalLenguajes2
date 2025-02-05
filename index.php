<?php
session_start(); // Asegúrate de que la sesión esté iniciada
require_once dirname(__FILE__) . '/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Corregir el enlace al favicon -->
  <link rel="icon" href="<?= BASE_URL ?>assets/logo.ico" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Raices de Cuyo</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-cyborg-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <?php include("./components/header.php"); ?>
  <!-- ***** Header Area End ***** -->

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
                <<div class="header-text text-center">
                <h4><em>Disfruta</em> de los mejores vinos</h4>
                <h6>Bienvenido a Raíces de Cuyo</h6>
                <div class="main-button">
                <a href="<?= BASE_URL ?>views/login_register/index.php">Iniciar sesión</a>
                </div>
</div>
          <!-- ***** Most Popular Start ***** -->
          <div class="most-popular" id="most-popular">
            <div class="row">
              <div class="col-lg-12">
                <div class="heading-section">
                  <h4>Productos Disponibles</h4>
                </div>
                <div class="row">
                  <?php
                  require_once('./views/crud_productos/Productos.php');
                  $productos = new Productos();
                  $productos = $productos->obtenerTodosLosProductos(); // Método corregido
                  ?>
                  <?php foreach ($productos as $row): ?>
                    <div class="col-lg-3 col-sm-6">
                      <div class="item">
                        <img class="w-100 img-fluid h-auto" src="<?= $row['imagen_url'] ?>" alt="Imagen no encontrada" />
                        <h4><?= $row['nombre'] ?><br><span></h4>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (isset($_SESSION['email'])): ?>
                    <div class="col-lg-12">
                      <div class="main-button">
                        <a href="<?= BASE_URL ?>views/crud_productos/index.php">Agregar productos</a>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          
<!-- ***** historia ***** -->
<div class="container" style="display: flex; flex-wrap: wrap; gap: 20px; color:rgb(255, 255, 255); font-family: 'Georgia', serif; line-height: 1.6;">
    <div style="flex: 1; max-width: 600px;">
        <h1 style="font-size: 2.5em; margin-bottom: 20px;">Nuestra Historia</h1>
        <p class="text-content" style="font-size: 1.2em; margin-bottom: 20px;color:rgb(255, 255, 255);">
            Raíces de Cuyo nació en el corazón del Valle del Tulum, San Juan, cuando Don Mateo Peralta, inspirado por las riquezas de la tierra cuyana, decidió plantar las primeras vides en 1970. Con esfuerzo y pasión, convirtió un terreno árido en un viñedo que reflejara el espíritu y las tradiciones de la región. Cada cosecha se convirtió en un homenaje a las raíces familiares y culturales, dando origen a vinos únicos que honran el paisaje y la historia sanjuanina.
        </p>
        <div class="history-section">
            <div class="history-item">
                <h2 style="font-size: 2em; margin-bottom: 10px;">Desde 1970</h2>
                <p style="font-size: 1.2em;color:rgb(255, 255, 255);">
                    Por más de 50 años, Raíces de Cuyo ha sido sinónimo de calidad y autenticidad. Con una dedicación inquebrantable, evolucionamos de una bodega familiar a un referente de vinos premium, llevando el alma de San Juan al mundo entero.
                </p>
            </div>
        </div>
    </div>
    <div style="flex: 1; display: flex; justify-content: center; align-items: flex-start; margin-top: 100px;"> <!-- Ajuste con mayor distancia -->
        <img src="https://labodegadelasestrellas.com/wp-content/uploads/2024/01/barriles-nuevos-1024x759.webp" 
             alt="Barriles de vino" 
             style="width: 350px; height: auto; border-radius: 8px;">
    </div>
</div>
<!-- ***** historia end ***** -->

        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center" style="font-family: 'Georgia';">
                <a href="#">Raíces de Cuyo</a>
            </div>
        </div>
    </div>
</footer>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>
