<?php
require_once dirname(__FILE__) . '/../../Database.php'; //importa la clase `Database` para gestionar la conexión a la base de datos.

class Categorias //define la clase `Categorias`.
{
    private $db; //variable privada para la instancia de la clase `Database`.
    private $con; //variable privada para la conexión a la base de datos.

    public function __construct() //constructor de la clase.
    {
        $this->db = new Database(); //crea una instancia de la clase `Database`.
        $this->con = $this->db->getConnection(); //obtiene la conexión a la base de datos desde la instancia.
    }

    //método para obtener todas las categorías.
    public function obtenerTodasLasCategorias()
    {
        $sql = "SELECT * FROM Categorias"; //consulta SQL para seleccionar todas las categorías.
        $result = $this->con->query($sql); //ejecuta la consulta en la base de datos.
        $categorias = []; //inicializa un arreglo vacío para almacenar las categorías.

        if ($result) { // Verifica si la consulta tuvo éxito.
            while ($row = $result->fetch_assoc()) { // Itera sobre cada fila de resultados.
                $categorias[] = $row; // Agrega la fila actual al arreglo `$categorias`.
            }
        } else {
            error_log("Error al obtener las categorías: " . $this->con->error); // Registra un error en caso de fallo.
        }

        return $categorias; // Devuelve el arreglo de categorías.
    }

    // Método para crear una nueva categoría.
    public function crearCategorias($nombre, $descripcion)
    {
        $sql = "INSERT INTO Categorias (nombre, descripcion) VALUES (?, ?)"; // Consulta SQL para insertar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta SQL.

        if ($stmt === false) { // Verifica si la preparación de la consulta falló.
            error_log("Error al preparar la consulta: " . $this->con->error); // Registra el error.
            return false; // Devuelve `false` en caso de error.
        }

        $stmt->bind_param("ss", $nombre, $descripcion); // Asigna los valores de los parámetros a la consulta.
        $result = $stmt->execute(); // Ejecuta la consulta.
        $stmt->close(); // Cierra la declaración preparada.

        if (!$result) { // Verifica si la ejecución de la consulta falló.
            error_log("Error al ejecutar la consulta: " . $stmt->error); // Registra el error.
        }

        return $result; // Devuelve `true` si la consulta tuvo éxito, de lo contrario `false`.
    }

    // Método para obtener una categoría por su ID.
    public function obtenerCategoriasPorId($id)
    {
        $sql = "SELECT * FROM Categorias WHERE id_categoria = ?"; // Consulta SQL para seleccionar una categoría específica.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if ($stmt === false) { // Verifica si la preparación falló.
            error_log("Error al preparar la consulta: " . $this->con->error); // Registra el error.
            return null; // Devuelve `null` en caso de error.
        }

        $stmt->bind_param("i", $id); // Asigna el valor del ID como parámetro.
        $stmt->execute(); // Ejecuta la consulta.
        $result = $stmt->get_result(); // Obtiene los resultados de la consulta.
        $stmt->close(); // Cierra la declaración preparada.

        if ($result && $result->num_rows > 0) { // Verifica si hay resultados.
            return $result->fetch_assoc(); // Devuelve la fila asociada.
        }

        return null; // Devuelve `null` si no se encuentra la categoría.
    }

    // Método para actualizar una categoría.
    public function actualizarCategorias($id, $nombre, $descripcion)
    {
        $sql = "UPDATE Categorias SET nombre = ?, descripcion = ? WHERE id_categoria = ?"; // Consulta SQL para actualizar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if ($stmt === false) { // Verifica si la preparación falló.
            error_log("Error al preparar la consulta: " . $this->con->error); // Registra el error.
            return false; // Devuelve `false` en caso de error.
        }

        $stmt->bind_param("ssi", $nombre, $descripcion, $id); // Asigna los valores a los parámetros.
        $result = $stmt->execute(); // Ejecuta la consulta.
        $stmt->close(); // Cierra la declaración preparada.

        if (!$result) { // Verifica si la ejecución falló.
            error_log("Error al ejecutar la consulta: " . $stmt->error); // Registra el error.
        }

        return $result; // Devuelve `true` si tuvo éxito, de lo contrario `false`.
    }

    // Método para eliminar una categoría.
    public function eliminarCategorias($id)
    {
        $sql = "DELETE FROM Categorias WHERE id_categoria = ?"; // Consulta SQL para eliminar una categoría.
        $stmt = $this->con->prepare($sql); // Prepara la consulta.

        if ($stmt === false) { // Verifica si la preparación falló.
            error_log("Error al preparar la consulta: " . $this->con->error); // Registra el error.
            return false; // Devuelve `false` en caso de error.
        }

        $stmt->bind_param("i", $id); // Asigna el valor del ID como parámetro.
        $result = $stmt->execute(); // Ejecuta la consulta.
        $stmt->close(); // Cierra la declaración preparada.

        if (!$result) { // Verifica si la ejecución falló.
            error_log("Error al ejecutar la consulta: " . $stmt->error); // Registra el error.
        }

        return $result; // Devuelve `true` si tuvo éxito, de lo contrario `false`.
    }

    // Método para cerrar la conexión a la base de datos.
    public function cerrarConexion()
    {
        $this->con->close(); // Cierra la conexión con la base de datos.
    }
}
?>
