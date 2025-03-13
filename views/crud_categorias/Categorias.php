<?php
require_once dirname(__FILE__) . '/../../Database.php'; // Importa la clase `Database` para gestionar la conexión a la base de datos.

class Categorias // Define la clase `Categorias`.
{
    private $db; // Variable privada para la instancia de la clase `Database`.
    private $con; // Variable privada para la conexión a la base de datos.

    public function __construct() // Constructor de la clase.
    {
        $this->db = new Database(); // Crea una instancia de la clase `Database`.
        $this->con = $this->db->getConnection(); // Obtiene la conexión a la base de datos desde la instancia.
    }

    // Método para obtener todas las categorías.
    public function obtenerTodasLasCategorias()
    {
        $sql = "SELECT * FROM Categorias"; // Consulta SQL para seleccionar todas las categorías.
        $result = $this->con->query($sql);

        if (!$result) { // Verifica si hubo un error en la consulta.
            throw new Exception("Error en la consulta: " . $this->con->error); // Lanza una excepción con el mensaje de error.
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Retorna los resultados como un array asociativo.
    }

    // Método para crear una nueva categoría.
    public function crearCategorias($nombre, $descripcion)
    {
        $sql = "INSERT INTO Categorias (nombre, descripcion) VALUES (?, ?)"; // Consulta SQL para insertar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta SQL.

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("ss", $nombre, $descripcion);   // Asigna los valores a los parámetros de la consulta.
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al insertar el proveedor: " . $this->con->error);
        }

        return $resultado; // Retorna `true` si la inserción fue exitosa.
    }

    // Método para obtener una categoría por su ID.
    public function obtenerCategoriasPorId($id)
    {
        $sql = "SELECT * FROM Categorias WHERE id_categoria = ?"; // Consulta SQL para seleccionar una categoría específica.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id); // Asigna el valor del ID al parámetro de la consulta.
        $stmt->execute();
        $result = $stmt->get_result(); // Obtiene los resultados.
        $stmt->close();

        if (!$result) {
            throw new Exception("Error al obtener el proveedor: " . $this->con->error);
        }

        return $result->fetch_assoc();
    }

    // Método para actualizar una categoría.
    public function actualizarCategorias($id, $nombre, $descripcion)
    {
        $sql = "UPDATE Categorias SET nombre = ?, descripcion = ? WHERE id_categoria = ?"; // Consulta SQL para actualizar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al actualizar el proveedor: " . $this->con->error);
        }

        return $resultado;
    }

    // Método para eliminar una categoría.
    public function eliminarCategorias($id)
    {
        $sql = "DELETE FROM Categorias WHERE id_categoria = ?"; // Consulta SQL para eliminar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if (!$stmt) {  // Verifica si hubo un error en la preparación de la consulta.
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al eliminar el proveedor: " . $this->con->error);
        }

        return $resultado;
    }

    /* Método para cerrar la conexión a la base de datos.
    public function cerrarConexion()
    {
        $this->con->close(); // Cierra la conexión con la base de datos.
    }
        */
}
?>
