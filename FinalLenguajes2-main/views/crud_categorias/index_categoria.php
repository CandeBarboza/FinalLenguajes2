<?php
session_start(); // Inicia una sesión para rastrear las variables de sesión.
if (!isset($_SESSION['email'])) { // Verifica si no hay una sesión activa con la clave 'email'.
    header('Location: index.html'); // Redirige al usuario a la página de inicio de sesión si no está autenticado.
    exit; // Detiene la ejecución del script.
}

include('Categorias.php'); // Incluye el archivo clase Categorias.

// Obtener todas las categorías
$categorias = new Categorias(); // Crea una instancia de la clase Categorias.
$categorias = $categorias->obtenerTodasLasCategorias(); // Llama al método para obtener todas las categorías de la base de datos.
?>

<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea adaptable a dispositivos móviles. -->
    <title>CRUD Categorias</title> <!-- Define el título de la página. -->
    <link rel="icon" href="../../assets/logo.ico" type="image/x-icon"> <!-- Establece el icono de la página. -->
    <link rel="stylesheet" href="../../assets/css/fontawesome.css"> <!-- Incluye estilos de Font Awesome. -->
    <link rel="stylesheet" href="../../assets/css/templatemo-cyborg-gaming.css"> <!-- Incluye un archivo CSS personalizado. -->
    <link rel="stylesheet" href="../../assets/css/owl.css"> <!-- Incluye otro archivo CSS personalizado. -->
    <link rel="stylesheet" href="../../assets/css/animate.css"> <!-- Añade animaciones a la página. -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" /> <!-- Añade estilos para un slider. -->
    <link rel="stylesheet" href="../../assets/css/productos.css"> <!-- Estilos personalizados para productos. -->
    <link rel="stylesheet" href="../../assets/css/index.css"> <!-- Estilos generales de la página. -->
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Incluye el CSS de Bootstrap para diseño responsivo. -->
</head>
<body>
    <?php include('../../components/header.php'); ?> <!-- Incluye el encabezado de la página desde un archivo externo. -->

    <div class="page-content mt-0"> <!-- Contenedor principal para el contenido de la página. -->
        <div class="container"> <!-- Contenedor Bootstrap para centrar y dar formato al contenido. -->
            <div class="card-template mb-4"> <!-- Un contenedor estilizado como tarjeta con margen inferior. -->
                <div class="header-card"> <!-- Cabecera de la tarjeta. -->
                    <h1>Crear Categoria</h1> <!-- Título de la sección de creación de categorías. -->
                </div>
                <div class="card-body"> 
                    <form action="create_categorias.php" method="POST" class="form-row"> <!-- Formulario que envía datos por POST al archivo 'create_categorias.php'. -->
                        <div class="form-group col-md-5"> 
                            <input type="text" name="nombre" placeholder="nombre" class="form-control" required> <!-- Input obligatorio para el nombre. -->
                        </div>
                        <div class="form-group col-md-5"> 
                            <input type="text" name="descripcion" placeholder="descripcion" class="form-control" required> <!-- Input obligatorio para la descripción. -->
                        </div>

                        <div class="form-group col-md-4"> <!-- Botón para enviar el formulario. -->
                            <button type="submit" class="btn-pink">Agregar Categoria</button> <!-- Botón personalizado para agregar una categoría. -->
                        </div>
                    </form>
                </div>
            </div>

            <div> <!-- Sección para mostrar las categorías registradas. -->
                <h2>Categorias Registradas</h2> 
                <table class="table table-striped table-bordered"> 
                    <thead class="thead-dark"> 
                        <tr>
                            <th>ID Categoria</th> <!-- Columna para el ID de la categoría. -->
                            <th>Nombre</th> <!-- Columna para el nombre de la categoría. -->
                            <th>Descripcion</th> <!-- Columna para la descripción de la categoría. -->
                            <th colspan="2">Acciones</th> <!-- Columnas para las acciones (editar/eliminar). -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $row): ?> <!-- Itera sobre las categorías obtenidas. -->
                            <tr>
                                <td class="text-white"><?= $row['id_categoria'] ?></td> <!-- Muestra el ID de la categoría. -->
                                <td class="text-white"><?= $row['nombre'] ?></td> <!-- Muestra el nombre de la categoría. -->
                                <td class="text-white"><?= $row['descripcion'] ?></td> <!-- Muestra la descripción de la categoría. -->
                                <td><a href="update_categorias.php?id=<?= $row['id_categoria'] ?>" class="btn btn-warning btn-sm">Editar</a></td> <!-- Enlace para editar una categoría. -->
                                <td><a href="delete_categorias.php?id=<?= $row['id_categoria'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td> <!-- Enlace para eliminar una categoría. -->
                            </tr>
                        <?php endforeach; ?> <!-- Fin del bucle de categorías. -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

