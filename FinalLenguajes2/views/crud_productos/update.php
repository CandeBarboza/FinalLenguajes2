<?php
include('Productos.php');

$id = $_GET['id']; //Obtiene el ID del producto desde la URL a través del método GET.
$productos = new Productos();
$row = $productos->obtenerProductoPorId($id);

// Obtener las categorías disponibles
$categorias = $productos->obtenerCategorias();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar productos</title>

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
                    <h1>Editar productos</h1>
                </div>
                <div class="card-body">
                    <form action="edit_productos.php" method="POST" class="form-row">
                        <!-- ID oculto para identificar el producto -->
                        <input type="hidden" name="id" value="<?php echo $row['id_producto'] ?>">

                        <div class="form-group col-md-4">
                            <!-- Nombre: tipo texto -->
                            <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo $row['nombre'] ?>">
                        </div>

                        <div class="form-group col-md-8">
                            <!-- Precio: tipo number con step para decimales -->
                            <input type="number" step="0.01" name="precio" placeholder="Precio" class="form-control" value="<?php echo $row['precio'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <!-- Stock: tipo number para enteros -->
                            <input type="number" name="stock" placeholder="Stock" class="form-control" value="<?php echo $row['stock'] ?>">
                        </div>

                        <div class="form-group col-md-12">
                            <!-- Imagen: tipo url para validación de enlaces -->
                            <input type="url" name="imagen" placeholder="URL Imagen" class="form-control" value="<?php echo $row['imagen_url'] ?>">
                        </div>

                        <div class="form-group col-md-12">
                            <!-- Seleccionar categoría -->
                            <select name="id_categoria" class="form-control">
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>" 
                                        <?php echo $categoria['id_categoria'] == $row['id_categoria'] ? 'selected' : ''; ?>>
                                        <?php echo $categoria['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn-pink">Modificar productos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
