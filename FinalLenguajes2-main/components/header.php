<?php
// Incluye el archivo de direccion de la web
require_once dirname(__FILE__) . '/../config.php';

// Incluye el archivo de sesión para manejar las sesiones del usuario
include_once dirname(__FILE__) . '/../session.php';
?>
<header class="header-area position-relative">
  <!-- Contenedor principal del encabezado -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- Inicio del menú de navegación -->
        <nav class="main-nav">
          <!-- ***** Logo Start ***** -->
          <a href="<?= BASE_URL ?>index.php" class="logo">
            <img src="<?= BASE_URL ?>assets/images/logo.png" alt="">
          </a>
          <!-- ***** Logo End ***** -->
          <!-- ***** Menu Start ***** -->
          <ul class="nav">
            <!-- Verifica si el usuario ha iniciado sesión mediante la variable de sesión -->
            <?php if (isset($_SESSION['email'])): ?>
              <!-- Opciones exclusivas para usuarios logueados -->
              <li><a href="<?= BASE_URL ?>index.php">Home</a></li> <!-- Enlace a la página de inicio -->
              <li><a href="<?= BASE_URL ?>views/crud_productos/index.php">Productos</a></li> <!-- Enlace al CRUD de productos -->
              <li><a href="<?= BASE_URL ?>views/crud_categorias/index.php">Categorias</a></li> <!-- Enlace al CRUD de categorías -->
              <li><a href="<?= BASE_URL ?>views/crud_reseñas/index.php">Reseñas</a></li> <!-- Enlace al CRUD de reseñas -->
              <li><a href="<?= BASE_URL ?>views/crud_proveedores/index.php">Proveedores</a></li> <!-- Enlace al CRUD de proveedores -->
              <!-- Botón de cerrar sesión -->
              <li class="logout-option"><a href="<?= BASE_URL ?>views/login_register/logout.php">Cerrar sesión</a></li>
            <?php else: ?>
              <!-- Opción de inicio de sesión para usuarios no logueados -->
              <li><a href="<?= BASE_URL ?>views/login_register/index.php" class="active">Iniciar sesión</a></li> <!-- Enlace a la página de login -->
            <?php endif; ?>
          </ul>
        </nav>
        <!-- Fin del menú de navegación -->
      </div>
    </div>
  </div>
</header>
