<?php
include('Productos.php');

// Procesar la actualización solo si el formulario fue enviado con el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $precio = isset($_POST['precio']) ? (float)$_POST['precio'] : 0;
    $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
    $tipo_envase = isset($_POST['tipo_envase']) ? (int)$_POST['tipo_envase'] : '';
    $imagen_url = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';
    $id_categoria = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 0;

    if ($id > 0 && !empty($nombre) && $precio > 0 && $stock >= 0 && !empty($tipo_envase) && !empty($imagen_url) && $id_categoria > 0) {
        try {
            $productos = new Productos();
            if ($productos->actualizarProducto($id, $nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria)) {
                header("Location: index.php?message=Producto actualizado correctamente");
                exit;
            } else {
                throw new Exception("Error al actualizar el producto.");
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos correctamente.";
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("ID no válido.");
}

$productos = new Productos();
$row = $productos->obtenerProductoPorId($id);
$categorias = $productos->obtenerCategorias();

if (!$row) {
    die("Producto no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Productos</title>

    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/css/templatemo-cyborg-gaming.css">
    <link rel="stylesheet" href="../../assets/css/owl.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../../assets/css/productos.css">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../../components/header.php'); ?>
    <div class="page-content mt-0">
        <div class="container">
            <div class="card-template mb-4">
                <div class="header-card">
                    <h1>Editar Productos</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST" class="form-row">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_producto']); ?>">
                        <div class="form-group col-md-4">
                            <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="number" step="0.01" name="precio" placeholder="Precio" class="form-control" value="<?php echo htmlspecialchars($row['precio']); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="number" name="stock" placeholder="Stock" class="form-control" value="<?php echo htmlspecialchars($row['stock']); ?>" required>
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
                        <div class="form-group col-md-12">
                            <input type="url" name="imagen" placeholder="URL Imagen" class="form-control" value="<?php echo htmlspecialchars($row['imagen_url']); ?>" required>
                        </div>
                        <div class="form-group col-md-12">
                            <select name="id_categoria" class="form-control" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>" 
                                        <?php echo $categoria['id_categoria'] == $row['id_categoria'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($categoria['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn-pink">Modificar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

