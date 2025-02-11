<?php
require_once dirname(__FILE__) . '/../../Database.php';

class Productos
{
    private $db;
    private $con;

    public function __construct()
    {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }



    // Método privado que devuelve una imagen por defecto si no hay una imagen proporcionada
    private function obtenerImagenPorDefecto($imagen_url)
    {
        return empty($imagen_url) 
            ? 'https://ih1.redbubble.net/image.1861329650.2941/flat,750x,075,f-pad,750x1000,f8f8f8.jpg' 
            : $imagen_url;
    }




    /*public function obtenerTodosLosProductos()
    {
        try {
            $sql = "SELECT p.id_producto, p.nombre, p.precio, p.stock, p.imagen_url, c.nombre AS categoria
                    FROM productos p
                    INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                    ORDER BY p.id_producto ASC";
            $result = $this->con->query($sql);// Ejecuta la consulta
            $productos = [];// Inicializa el array de productos

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row['imagen_url'] = $this->obtenerImagenPorDefecto($row['imagen_url']); 
                    $productos[] = $row; // Agrega el producto al array
                }
            }
            return $productos;
        } catch (Exception $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
            return [];
        }
    }*/



    public function obtenerTodosLosProductos()
    {
        $sql = "SELECT * FROM Productos"; //consulta SQL para seleccionar todos los productos.
        $result = $this->con->query($sql); //ejecuta la consulta en la base de datos.
        $productos = []; //inicializa un arreglo vacío para almacenar los productos.

        if ($result) { //verifica si la consulta tuvo éxito.
            while ($row = $result->fetch_assoc()) { //itera sobre cada fila de resultados.
                $productos[] = $row; //agrega la fila actual al arreglo `$productos`.
            }
        } else {
            error_log("Error al obtener los productos: " . $this->con->error); //registra un error en caso de fallo.
        }

        return $productos; //devuelve el arreglo de productos.
    }




    /*public function crearProducto($nombre, $precio, $stock, $imagen_url, $id_categoria)
    {
        if (empty($nombre) || empty($imagen_url)) {
            return ['success' => false, 'message' => 'El nombre y la imagen son campos obligatorios.'];
        }

        $imagen_url = $this->obtenerImagenPorDefecto($imagen_url);

        if ($precio < 0 || $stock < 0) {
            return ['success' => false, 'message' => 'El precio y el stock deben ser valores positivos.'];
        }

        if (!$this->categoriaExiste($id_categoria)) {
            return ['success' => false, 'message' => 'La categoría seleccionada no existe.'];
        }

        try {
            $sql = "INSERT INTO productos (nombre, precio, stock, imagen_url, id_categoria) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sdisi", $nombre, $precio, $stock, $imagen_url, $id_categoria); // Asigna valores


            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Producto creado exitosamente.'];
            } else {
                return ['success' => false, 'message' => 'Error al crear el producto.'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al crear el producto: ' . $e->getMessage()];
        }
    }*/



    public function crearProducto($nombre, $precio, $stock, $imagen_url, $id_categoria)
    {
    $sql = "INSERT INTO Productos (nombre, precio, stock, imagen_url, id_categoria) VALUES (?, ?, ?, ?, ?)"; //consulta SQL para insertar un producto.
        $stmt = $this->con->prepare($sql); //prepara la consulta SQL.

        if ($stmt === false) { //verifica si la preparación de la consulta falló.
            error_log("Error al preparar la consulta: " . $this->con->error); //registra el error.
            return false; //devuelve `false` en caso de error.
        }

        $stmt->bind_param("sssss", $nombre, $precio, $stock, $imagen_url, $id_categoria); //asigna los valores de los parámetros a la consulta.
        $result = $stmt->execute(); //ejecuta la consulta.
        $stmt->close(); //cierra la declaración preparada.

        if (!$result) { // Verifica si la ejecución de la consulta falló.
            error_log("Error al ejecutar la consulta: " . $stmt->error); // Registra el error.
        }

        return $result; // Devuelve `true` si la consulta tuvo éxito, de lo contrario `false`.
    }




    public function actualizarProducto($id, $nombre, $precio, $stock, $imagen_url, $id_categoria)
    {
        if (empty($nombre) || empty($imagen_url)) {
            return ['success' => false, 'message' => 'El nombre y la imagen son campos obligatorios.'];
        }

        $imagen_url = $this->obtenerImagenPorDefecto($imagen_url);

        if ($precio < 0 || $stock < 0) {
            return ['success' => false, 'message' => 'El precio y el stock deben ser valores positivos.'];
        }

        if (!$this->categoriaExiste($id_categoria)) {
            return ['success' => false, 'message' => 'La categoría seleccionada no existe.'];
        }

        try {
            $sql = "UPDATE productos 
                    SET nombre = ?, precio = ?, stock = ?, imagen_url = ?, id_categoria = ? 
                    WHERE id_producto = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sdisii", $nombre, $precio, $stock, $imagen_url, $id_categoria, $id);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Producto actualizado exitosamente.'];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar el producto.'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar el producto: ' . $e->getMessage()];
        }
    }

    public function eliminarProducto($id)
{
    try {
        // Verificar si el producto existe
        $producto = $this->obtenerProductoPorId($id);
        if (!$producto) {
            return ['success' => false, 'message' => 'El producto no existe.'];
        }

        // Eliminar el producto
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Producto eliminado exitosamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el producto.'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Error al eliminar el producto: ' . $e->getMessage()];
    }
}


    private function categoriaExiste($id_categoria)
    {
        try {
            $sql = "SELECT id_categoria FROM categorias WHERE id_categoria = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id_categoria);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->num_rows > 0;
        } catch (Exception $e) {
            echo "Error al verificar categoría: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerCategorias()
    {
        try {
            $sql = "SELECT id_categoria, nombre FROM categorias ORDER BY nombre ASC";
            $result = $this->con->query($sql);
            $categorias = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categorias[] = $row;
                }
            }
            return $categorias;
        } catch (Exception $e) {
            echo "Error al obtener categorías: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerProductoPorId($id)
    {
        try {
            $sql = "SELECT p.id_producto, p.nombre, p.precio, p.stock, p.imagen_url, p.id_categoria, c.nombre AS categoria
                    FROM productos p
                    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                    WHERE p.id_producto = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $producto = $result->fetch_assoc();
                $producto['imagen_url'] = $this->obtenerImagenPorDefecto($producto['imagen_url']);
                return $producto;
            }
            return null;
        } catch (Exception $e) {
            echo "Error al obtener el producto: " . $e->getMessage();
            return null;
        }
    }
}
?>


