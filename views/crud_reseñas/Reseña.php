<?php
require_once dirname(__FILE__) . '/../../Database.php';

class Reseña
{
    private $db;
    private $con;

    public function __construct()
    {
        $this->db = new Database();
        $this->con = $this->db->getConnection();
    }

    public function obtenerTodasLasReseñas()
    {
        $sql = "SELECT * FROM Reseñas";
        $result = $this->con->query($sql);

        if (!$result) { // Verifica si hubo un error en la consulta.
            throw new Exception("Error en la consulta: " . $this->con->error); // Lanza una excepción con el mensaje de error.
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Retorna los resultados como un array asociativo.
    }

    public function crearReseña($nombre, $mensaje, $fecha)
    {
        
        $sql = "INSERT INTO Reseñas (nombre, mensaje, fecha) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("sss", $nombre, $mensaje, $fecha);   // Asigna los valores a los parámetros de la consulta.
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al insertar la reseña: " . $this->con->error);
        }

        return $resultado; // Retorna `true` si la inserción fue exitosa.
    }

    public function obtenerReseñaPorId($id)
    {
        $sql = "SELECT * FROM Reseñas WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id); // Asigna el valor del ID al parámetro de la consulta.
        $stmt->execute();
        $result = $stmt->get_result(); // Obtiene los resultados.
        $stmt->close();

        if (!$result) {
            throw new Exception("Error al obtener la reseña: " . $this->con->error);
        }

        return $result->fetch_assoc();
    }

    public function actualizarReseña($id, $nombre, $mensaje, $fecha)
    {
        $sql = "UPDATE Reseñas SET nombre = ?, mensaje = ?, fecha = ? WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("sssi", $nombre, $mensaje, $fecha, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al actualizar la reseña: " . $this->con->error);
        }

        return $resultado;
    }

    public function eliminarReseña($id)
    {
        $sql = "DELETE FROM Reseñas WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {  // Verifica si hubo un error en la preparación de la consulta.
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            throw new Exception("Error al eliminar la reseña: " . $this->con->error);
        }

        return $resultado;
    }
}
?>



