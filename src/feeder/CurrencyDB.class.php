<?php

class CurrencyDB
{
    private $conn;

    public function connect() : void
    {
        try {
            $host = "db";
            $dbname = "currency";
            $user = "root";

            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user);
        } catch (\PDOException $e) { 
            throw new \Exception("Could not connect to the database: " . $e->getMessage());
        }
    }

    public function insertRate(string $base, string $symbol, float $value) : bool
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO rates (BASE, SYMBOL, VALUE) VALUES (:base, :symbol, :value)");

            $stmt->bindParam("base", $base);
            $stmt->bindParam("symbol", $symbol);
            $stmt->bindParam("value", $value);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Could not execute query: " . $e->getMessage());
        }
    }
}