<?php
include('Categorias.php');

// Procesar la actualización solo si el formulario fue enviado con el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    if ($id > 0 && !empty($nombre) && !empty($descripcion)) {
        try {
            $categorias = new Categorias();
            if ($categorias->actualizarCategorias($id, $nombre, $descripcion)) {
                header("Location: index.php?message=Categoría actualizada correctamente");
                exit;
            } else {
                throw new Exception("Error al actualizar la categoría.");
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("ID no válido.");
}

$categorias = new Categorias();
$row = $categorias->obtenerCategoriasPorId($id);

if (!$row) {
    die("Categoría no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
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
                    <h1>Editar Categoría</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST" class="form-row">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_categoria']); ?>">
                        <div class="form-group col-md-5">
                            <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" name="descripcion" placeholder="Descripción" class="form-control" value="<?php echo htmlspecialchars($row['descripcion']); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn-pink">Modificar Categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>   
</body>
</html>