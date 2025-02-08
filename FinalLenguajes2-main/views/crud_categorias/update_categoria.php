<?php
include('Categorias.php');

//obtener el ID de la categoría desde la URL
$id = $_GET['id'] ?? null;

//crear instancia de la clase Categorias
$categorias = new Categorias();
$row = $categorias->obtenerCategoriasPorId($id); //obtener los datos de la categoría a editar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
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
                    <h1>Editar Categoria</h1>
                </div>
                <div class="card-body">
                    <!-- Formulario para editar la categoría -->
                    <form action="update_categorias.php" method="POST" class="form-row">
                        <!-- Campo oculto con el ID de la categoría -->
                        <input type="hidden" name="id" value="<?php echo $row['id_categoria']; ?>">

                        <!-- Campo para el nombre de la categoría -->
                        <div class="form-group col-md-5">
                            <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo $row['nombre']; ?>" required>
                        </div>

                        <!-- Campo para la descripción de la categoría -->
                        <div class="form-group col-md-5">
                            <input type="text" name="descripcion" placeholder="Descripción" class="form-control" value="<?php echo $row['descripcion']; ?>" required>
                        </div>

                        <!-- Botón para enviar el formulario -->
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn-pink">Actualizar Categoria</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Lógica para actualizar la categoría cuando el formulario se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Crear una instancia de la clase Categorias y actualizar los datos
    $categorias->actualizarCategorias($id, $nombre, $descripcion);

// Después de actualizar la categoría
echo "<script>window.location.href = 'index.php';</script>";
exit;

}


?>

