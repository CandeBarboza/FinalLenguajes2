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

    public function obtenerTodosLasReseña()
    {
        $sql = "SELECT * FROM Reseñas";
        $result = $this->con->query($sql);
        $reseña = []; // Inicializa un array vacío para almacenar las reseñas obtenidas.

        if ($result) { // Verifica si la consulta se ejecutó correctamente.
            while ($row = $result->fetch_assoc()) { // Recorre cada fila del resultado como un array asociativo.
                $reseña[] = $row; // Agrega cada fila obtenida al array '$reseña'.
            }
        }
        return $reseña;
    }

    public function crearReseña($nombre, $mensaje, $fecha)
    {
        
        $sql = "INSERT INTO Reseñas (nombre, mensaje, fecha) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sss", $nombre, $mensaje, $fecha); // Asigna valores a los marcadores de posición en la consulta preparada.
        return $stmt->execute();
    }

    public function obtenerReseñaPorId($id)
    {
        $sql = "SELECT * FROM Reseñas WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result(); // Obtiene el resultado de la consulta preparada que se ejecutó previamente.
        return $result->fetch_assoc();
    }

    public function actualizarReseña($id, $nombre, $mensaje, $fecha)
    {
        $sql = "UPDATE Reseñas SET nombre = ?, mensaje = ?, fecha = ? WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $mensaje, $fecha, $id);
        return $stmt->execute();
    }

    public function eliminarReseña($id)
    {
        $sql = "DELETE FROM Reseñas WHERE id_reseña = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>



