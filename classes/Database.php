<?php

class Database
{
    private $connection;

    public function __construct($config)
    {
        $host = $config["host"];
        $database = $config["database"];
        $username = $config["username"];
        $password = $config["password"];

        try {

            $this->connection = new PDO(
                "mysql:host=$host;dbname=$database",
                $username,
                $password
            );

            
             $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {

            echo "Connection failed: " . $e->getMessage();

        }
    }
  //sql = "SELECT ?,? from ?" -> SELECT firstname, lastname from users
    public function select($sql, $params = []) //params[] = ["firstname", "lastname", "users"]
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

       public function insert($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $this->connection->lastInsertId();
    }

    public function update($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function delete($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

}