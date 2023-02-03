<?php

class Database
{
    // Учетные данные бд
    private $host = '92.53.96.243';
    private $db_name = 'cv38872_shop';
    private $username = 'cv38872_shop';
    private $password = 't7g4d6Pu';
    public $conn;

    // Получаем соединение с бд
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>