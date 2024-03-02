<?php

/**
 * Class Database
 * A simple PHP database class for establishing and managing PDO connections.
 */
class Database
{
    private $server = "mysql:host=localhost;dbname=ecomm";
    private $username = "root";
    private $password = "";
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );
    protected $conn;

    /**
     * Open a new database connection.
     * @return PDO|null Returns the PDO connection object on success, or null on failure.
     */
    public function open()
    {
        try {
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
            return $this->conn;
        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Close the current database connection.
     */
    public function close()
    {
        $this->conn = null;
    }
}

// Usage example:
// $pdo = new Database();

?>
