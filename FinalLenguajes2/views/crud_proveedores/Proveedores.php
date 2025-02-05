<?php
require_once dirname(__FILE__) . '/../../Database.php';

class Proveedores
{
    private $db;  // Propiedad para almacenar la instancia de la base de datos.
    private $con;  // Propiedad para almacenar la conexión a la base de datos.

    public function __construct()
    {
        $this->db = new Database(); // Crea una nueva instancia de la clase Database.
        $this->con = $this->db->getConnection(); // Obtiene la conexión a la base de datos.
    }

    // Obtener todos los proveedores
    public function obtenerTodosLosProveedores()
    {
        $sql = "SELECT id, nombre_proveedores, razon_social FROM Proveedores"; // Consulta SQL para obtener todos los proveedores.
        $result = $this->con->query($sql);

        if (!$result) { // Verifica si hubo un error en la consulta.
            throw new Exception("Error en la consulta: " . $this->con->error); // Lanza una excepción con el mensaje de error.
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Retorna los resultados como un array asociativo.
    }

    // Crear un nuevo proveedor
    public function crearProveedor($nombre_proveedores, $razon_social)
    {
        $sql = "INSERT INTO Proveedores (nombre_proveedores, razon_social) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("ss", $nombre_proveedores, $razon_social);   // Asigna los valores a los parámetros de la consulta.
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al insertar el proveedor: " . $this->con->error);
        }

        return $resultado; // Retorna `true` si la inserción fue exitosa.
    }

    // Obtener un proveedor por ID
    public function obtenerProveedorPorId($id)
    {
        $sql = "SELECT * FROM Proveedores WHERE id = ?";
        $stmt = $this->con->prepare($sql);

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

    // Actualizar un proveedor
    public function actualizarProveedor($id, $nombre_proveedores, $razon_social)
    {
        $sql = "UPDATE Proveedores SET nombre_proveedores = ?, razon_social = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("ssi", $nombre_proveedores, $razon_social, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al actualizar el proveedor: " . $this->con->error);
        }

        return $resultado;
    }

    // Eliminar un proveedor
    public function eliminarProveedor($id)
    {
        $sql = "DELETE FROM Proveedores WHERE id = ?";
        $stmt = $this->con->prepare($sql);

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
}
?>

