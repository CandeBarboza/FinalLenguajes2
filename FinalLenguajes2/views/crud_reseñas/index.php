<?php

session_start(); // Inicia o reanuda una sesión en PHP. Permite acceder a las variables de sesión.

// Verifica si la variable de sesión 'email' no está definida.
if (!isset($_SESSION['email'])) {  
    // Si no existe, significa que el usuario no ha iniciado sesión, por lo que es redirigido a la página de inicio de sesión.
    header('Location: index.html');  
    
    // Termina la ejecución del script para asegurarse de que no se ejecuten más instrucciones.
    exit;  
}

include('Reseña.php');

// Crear una instancia de la clase Reseña
$reseña = new Reseña();
$todasLasReseñas = $reseña->obtenerTodosLasReseña();  // Obtener todas las reseñas

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Reseñas</title>
    <link rel="icon" href="../../assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="../../assets/css/owl.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../../assets/css/productos.css">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Reseña eliminada correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == '1'): ?>
        <div class="alert alert-danger">Hubo un error al intentar eliminar una reseña. Inténtalo nuevamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'foreign_key'): ?>
        <div class="alert alert-warning">
            No se puede eliminar esta reseña.
        </div>
    <?php endif; ?>

    <?php include('../../components/header.php'); ?>

    <div class="page-content mt-0">
        <div class="container">
            <div class="card-template mb-4">
                <div class="header-card">
                    <h1>Crear Reseña</h1>
                </div>
                <div class="card-body">
                    <form action="create_reseña.php" method="POST" class="form-row">
                        <div class="form-group col-md-5">
                            <input type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" required>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" name="mensaje" placeholder="Mensaje" class="form-control" required>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn-pink">Agregar Reseña</button>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <h2>Reseñas Registradas</h2>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todasLasReseñas as $row): ?>
                            <tr>
                                <td class="text-white"><?= $row['id_reseña'] ?></td>
                                <td class="text-white"><?= $row['nombre'] ?></td>
                                <td class="text-white"><?= $row['mensaje'] ?></td>
                                <td class="text-white"><?= $row['fecha'] ?></td>
                                <td><a href="update_reseña.php?id=<?= $row['id_reseña'] ?>" class="btn btn-warning btn-sm">Editar</a></td>
                                <td><a href="delete_reseña.php?id=<?= $row['id_reseña'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
</body>

</html>
