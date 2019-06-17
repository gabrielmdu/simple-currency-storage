<?php

/**
 * Handles operations related to the currency database
 */
class CurrencyDB
{
    private $conn;

    /**
     * Connects to the database
     *
     * @return void
     * @throws Exception If connection failed
     */
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

    /**
     * Insert an exchange rate into the database
     *
     * @param  string $base The base currency to be converted
     * @param  string $symbol The currency the base is converted to
     * @param  float $value The converted rate value
     * @param  string $datetime The datetime when it was inserted
     *
     * @return bool The insertion result
     */
    public function insertRate(string $base, string $symbol, float $value, string $datetime = null) : bool
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO rates (BASE, SYMBOL, VALUE, DATETIME)
                                          VALUES (:base, :symbol, :value, :datetime)");

            if ($datetime === null) {
                $timezone = new DateTimeZone("America/Sao_Paulo");
                $datetime = (new \DateTime("now", $timezone))->format("Y-m-d H:i:s");
            }

            $stmt->bindParam("base", $base);
            $stmt->bindParam("symbol", $symbol);
            $stmt->bindParam("value", $value);
            $stmt->bindParam("datetime", $datetime);

            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new \Exception("Could not execute query: " . $e->getMessage());
        }
    }
}