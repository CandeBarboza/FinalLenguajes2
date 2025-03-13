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

    // Obtener todos los productos con su categoría asociada
    public function obtenerTodosLosProductos()
    {
        $sql = "SELECT p.id_producto, p.nombre, p.precio, p.stock, p.tipo_envase, p.imagen_url, 
                       c.id_categoria, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria";
        $result = $this->con->query($sql);

        if (!$result) {
            throw new Exception("Error en la consulta: " . $this->con->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener todas las categorías.
    public function obtenerCategorias()
    {
        $query = "SELECT id_categoria, nombre FROM categorias";
        $resultado = $this->con->query($query); // 🔹 Corregido $this->conexion a $this->con

        if (!$resultado) {
            throw new Exception("Error en la consulta: " . $this->con->error);
        }

        $categorias = [];
        while ($fila = $resultado->fetch_assoc()) {
            $categorias[] = $fila;
        }

        return $categorias;
    }

    // Crear un nuevo producto
    public function crearProducto($nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria)
    {
        $sql = "INSERT INTO productos (nombre, precio, stock, tipo_envase, imagen_url, id_categoria) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("sdissi", $nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al insertar el producto: " . $this->con->error);
        }

        return $resultado;
    }

    // Obtener un producto por ID con su categoría
    public function obtenerProductoPorId($id)
    {
        $sql = "SELECT p.id_producto, p.nombre, p.precio, p.stock, p.tipo_envase, p.imagen_url, 
                       c.id_categoria, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE p.id_producto = ?";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if (!$result) {
            throw new Exception("Error al obtener el producto: " . $this->con->error);
        }

        return $result->fetch_assoc();
    }

    // Actualizar un producto
    public function actualizarProducto($id, $nombre, $precio, $stock, $imagen_url, $id_categoria)
    {
        $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ?, tipo_envase = ?, imagen_url = ?, id_categoria = ? WHERE id_producto = ?";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("sdisii", $nombre, $precio, $stock, $tipo_envase, $imagen_url, $id_categoria, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al actualizar el producto: " . $this->con->error);
        }

        return $resultado;
    }

    // Eliminar un producto
    
    public function eliminarProducto($id)
    {
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al eliminar el producto: " . $this->con->error);
        }

        return $resultado;
    }

    /*
    public function eliminarProducto($id)
    {
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->con->prepare($sql);
    
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->con->error);
        }
    
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $filas_afectadas = $stmt->affected_rows; // Guardamos el número de filas afectadas
        $stmt->close();
    
        return $filas_afectadas > 0; // Si se eliminó al menos una fila, retorna true
    }    
*/

}

?>