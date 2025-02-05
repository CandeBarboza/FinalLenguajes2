<?php

session_start();
if (!isset($_SESSION['email'])) { // Verifica si el usuario no ha iniciado sesión
    header('Location: index.html'); // Si no está autenticado, redirige al usuario a la página de inicio (index.html).
    exit;
}

include('Proveedores.php');

$proveedores = new Proveedores(); //Se crea un objeto para poder utilizar los métodos de esa clase, como actualizarProveedor().
$proveedores = $proveedores->obtenerTodosLosProveedores();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Proveedores</title>
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
    <?php include('../../components/header.php'); ?>
    
    <div class="page-content mt-0">
        <div class="container">
            <div class="card-template mb-4">
                <div class="header-card">
                    <h1>Crear Proveedores</h1>
                </div>
                <div class="card-body">
                    <form action="create_proveedores.php" method="POST" class="form-row">
                        <div class="form-group col-md-5">
                            <input type="text" name="nombre_proveedores" placeholder="Nombre Proveedores" class="form-control" required>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" name="razon_social" placeholder="razon_social" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn-pink">Agregar Proveedores</button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <h2>Proveedores Registradas</h2>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Proveedores</th>
                            <th>Nombre Proveedores</th>
                            <th>razon_social</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $row): ?>
                            <tr>
                                <td class="text-white"><?= $row['id'] ?></td>
                                <td class="text-white"><?= $row['nombre_proveedores'] ?></td>
                                <td class="text-white"><?= $row['razon_social'] ?></td>
                                <td><a href="update_proveedores.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a></td>
                                <td><a href="delete_proveedores.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
