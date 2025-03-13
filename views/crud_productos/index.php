<?php

session_start(); //inicia o reanuda una sesión en PHP. Permite acceder a las variables de sesión.

//verifica si la variable de sesión 'email' no está definida.
if (!isset($_SESSION['email'])) {  
    //si no existe, significa que el usuario no ha iniciado sesión, por lo que es redirigido a la página de inicio de sesión.
    header('Location: index.html');  
    
    //termina la ejecución del script para asegurarse de que no se ejecuten más instrucciones.
    exit;  
}


include('Productos.php');
// Instanciamos la clase Productos
$productos = new Productos();

// Guardamos la lista de productos en una variable diferente
$listaProductos = $productos->obtenerTodosLosProductos();

// Obtenemos las categorías 
$categorias = $productos->obtenerCategorias();
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
                        <div class="form-group col-md-12">
                         <label for="tipo_envase">Selecciona un tipo de envase</label>
                         <select id="tipo_envase" name="tipo_envase" class="form-control" required>
                            <option value="" disabled selected>Selecciona un tipo de envase</option>
                            <option value="pequeño">Pequeño</option>
                            <option value="mediano">Mediano</option>  
                            <option value="grande">Grande</option>
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="url" name="imagen_url" placeholder="URL Imagen" class="form-control" required>
                        </div>
                        <div class="form-group col-md-12">
                            <select name="id_categoria" class="form-control" required>
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
                        <th>Tipo de Envase</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($listaProductos as $row): ?>
                            <tr>
                                <td class="text-white"><?= $row['id_producto'] ?></td>
                                <td class="text-white"><?= $row['nombre'] ?></td>
                                <td class="text-white"><?= $row['precio'] ?></td>
                                <td class="text-white"><?= $row['stock'] ?></td>
                                <td class="text-white"><?= $row['tipo_envase'] ?></td>
                                <td class="text-white">
                                    <?php if (!empty($row['imagen_url'])): ?>
                                        <img src="<?= htmlspecialchars($row['imagen_url']) ?>" alt="Imagen" width="80" height="100" 
                                        style="object-fit: contain; vertical-align: middle;">
                                    <?php else: ?>
                                        Sin imagen
                                    <?php endif; ?>
                                </td>
                                <td><a href="update.php?id=<?= $row['id_producto'] ?>" class="btn btn-warning btn-sm">Editar</a></td>
                                <td><a href="delete_productos.php?id=<?= $row['id_producto'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>