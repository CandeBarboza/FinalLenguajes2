<?php
class Database
{
  private $host;
  private $user;
  private $pass;
  private $dbname;
  private $con;

  public function __construct()
  {
    $this->host = 'localhost';
    $this->user = 'root';
    $this->pass = '';
    $this->dbname = 'raices_de_cuyo_db';
    $this->con = $this->connect();
  }

  private function connect()
  {
    try {
      $con = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
      if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
      }
      return $con;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      exit;
    }
  }

  public function getConnection()
  {
    return $this->con;
  }

  public function closeConnection()
  {
    if ($this->con) {
      $this->con->close();
    }
  }
}
?>
