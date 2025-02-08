<?php
class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($fullname, $email, $username, $password)
    {
        // Verificar si el correo electrónico ya está registrado
        $checkEmailQuery = "SELECT email FROM users WHERE email = ?";  // Usamos 'email' 
        $stmt = $this->conn->prepare($checkEmailQuery);

        if (!$stmt) {  // Verifica si la preparación de la consulta SQL falló (si $stmt es false).
            die("Error al preparar la consulta: " . $this->conn->error);  // Si ocurrió un error, muestra un mensaje de error y detiene la ejecución del script.
        }
        
        $stmt->bind_param('s', $email);  // Asocia el valor de la variable $email con el parámetro en la consulta SQL (en este caso, 's' indica que es un string).
        $stmt->execute();  // Ejecuta la consulta SQL preparada.
        $stmt->store_result();  // Almacena el resultado de la consulta, lo que permite acceder a él posteriormente.
        

        if ($stmt->num_rows > 0) {  // Verifica si el número de filas devueltas por la consulta es mayor que 0 (es decir, si ya existe un registro con el correo ingresado).
            return 'duplicate_email';  // Si ya hay un correo duplicado en la base de datos, retorna un mensaje indicando que el correo ya está registrado.
        }
        

        // Si no hay duplicados, proceder con el registro
        $query = "INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) { // Verifica si la preparación de la consulta SQL falló (si $stmt es false).
            die("Error al preparar la consulta: " . $this->conn->error); // Si ocurrió un error, muestra un mensaje de error
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('ssss', $fullname, $email, $username, $hashedPassword);

        try {
            $stmt->execute();
            return true;  // Registro exitoso
        } catch (mysqli_sql_exception $e) {
            // Otros errores que no sean claves duplicadas
            throw $e; 
        }
    }

    public function login($email, $password)
    {
        // Verificar si el usuario existe con el correo electrónico
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();  // Ejecuta la consulta preparada y obtiene el resultado de la consulta.
        $user = $result->fetch_assoc();  // Obtiene la primera fila del resultado de la consulta como un array asociativo, lo que representa los datos del usuario.


        // Verificar la contraseña
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;  // Credenciales incorrectas
    }
}
?>

