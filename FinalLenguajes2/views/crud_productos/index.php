<?php
// Manejo de sesión
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.html');
    exit;
}

include('Productos.php');

// Crear una instancia de la clase Productos
$productosObj = new Productos();

// Obtener todos los productos
$productos = $productosObj->obtenerTodosLosProductos();

// Obtener las categorías desde la base de datos
$categorias = $productosObj->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos</title>
    <link rel="icon" href="../../assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="../../assets/css/owl.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../assets/css/productos.css">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Cambiar el color del texto dentro de las celdas de la tabla */
        .table tbody td {
            color: white; /* Cambiar color a blanco */
        }
    </style>
</head>

<body>
    <?php include('../../components/header.php'); ?>

    <div class="page-content mt-0">
        <div class="container">
            <!-- Formulario para agregar un nuevo producto -->
            <div class="card-template mb-4">
                <div class="header-card">
                    <h1>Crear Producto</h1>
                </div>
                <div class="card-body">
                    <form action="create-productos.php" method="POST" class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" step="0.01" name="precio" placeholder="Precio" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="url" name="imagen" placeholder="URL Imagen" class="form-control" required>
                        </div>
                        <div class="form-group col-md-12">
                            <select name="categoria" class="form-control" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= htmlspecialchars($categoria['id_categoria']) ?>">
                                        <?= htmlspecialchars($categoria['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn-pink">Agregar Producto</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla para mostrar los productos registrados -->
            <h2>Productos Registrados</h2>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($productos as $producto): ?> 
    <!-- Bucle foreach que recorre el array $productos, asignando cada elemento a la variable $producto -->

                <tr>
                    <td><?= htmlspecialchars($producto['id_producto']) ?></td> 
                     <!-- Muestra el ID del producto y usa htmlspecialchars() para evitar ataques XSS -->

                     <td><?= htmlspecialchars($producto['nombre']) ?></td> 
                     <!-- Muestra el nombre del producto, aplicando htmlspecialchars() por seguridad -->

                     <td><?= htmlspecialchars($producto['precio']) ?></td> 
                     <!-- Muestra el precio del producto, también protegido con htmlspecialchars() -->

                    <td><?= htmlspecialchars($producto['stock']) ?></td> 
                     <!-- Muestra la cantidad de stock del producto -->

                    <td>
                <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" 
                 alt="Imagen del producto" 
                 class="img-thumbnail" 
                 style="width: 80px; height: 80px;">
                <!-- Muestra la imagen del producto con un tamaño definido de 80x80 px.
                 Se usa htmlspecialchars() para evitar inyección de código en la URL de la imagen -->
                    </td>

                    <td><?= htmlspecialchars($producto['categoria']) ?></td>  
                    <!-- Muestra la categoría del producto -->

                   <td>
                        <a href="update.php?id=<?= urlencode($producto['id_producto']) ?>" class="btn btn-warning btn-sm">Editar</a>
                         <!-- Enlace para editar el producto, pasando el ID del producto por la URL.
                 Se usa urlencode() para asegurar que el valor sea seguro en la URL -->
                    </td>

                    <td>
                        <a href="delete_productos.php?id=<?= urlencode($producto['id_producto']) ?>" 
                         class="btn btn-danger btn-sm" 
                        onclick="return confirm('¿Estás seguro de eliminar este producto?');">
                        Eliminar
                    </a>
                     <!-- Enlace para eliminar el producto, pasando el ID por la URL con urlencode().
                 Se usa un confirm() en JavaScript para pedir confirmación antes de eliminar -->
                    </td>
                </tr>
<?php endforeach; ?> 
<!-- Fin del bucle foreach -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
