<?php
include('Proveedores.php');

// Procesar la actualización solo si el formulario fue enviado con el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del proveedor desde el formulario, asegurando que sea un número entero
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    // Obtener y limpiar el nombre del proveedor, eliminando espacios en blanco al inicio y al final
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    // Obtener y limpiar la razón social, eliminando espacios en blanco al inicio y al final
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    // Validar los campos obligatorios no esten vacios y el id sea mayor a 0
    if ($id > 0 && !empty($nombre) && !empty($descripcion)) {
        try {
            $proveedores = new Proveedores();
            // Intentar actualizar el proveedor en la base de datos
            if ($proveedores->actualizarProveedor($id, $nombre, $descripcion)) {
                // Redirigir a la página principal con un mensaje de éxito
                header("Location: index.php?message=Proveedor actualizado correctamente");
                exit;
            } else {
                throw new Exception("Error al actualizar el proveedor.");
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}

// Obtener el ID del proveedor desde la URL (GET) y asegurarse de que sea un número entero
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// Si el ID no es válido (menor o igual a 0), mostrar un mensaje de error y detener la ejecución
if ($id <= 0) {
    die("ID no válido.");
}

$proveedores = new Proveedores();
$row = $proveedores->obtenerProveedorPorId($id);

// Si no se encuentra el proveedor en la base de datos, mostrar un mensaje de error y detener la ejecución
if (!$row) {
    die("Proveedor no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedores</title>

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
                    <h1>Editar Proveedores</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST" class="form-row">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <div class="form-group col-md-5">
                            <input type="text" name="nombre" placeholder="Nombre Proveedores" class="form-control" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" name="descripcion" placeholder="Razón Social" class="form-control" value="<?php echo htmlspecialchars($row['descripcion']); ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn-pink">Modificar Proveedores</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>   
</body>
</html>
