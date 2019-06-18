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
    public function connect(): void
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
     * @return bool Returns whether the query execution was successful or not
     */
    public function insertRate(string $base, string $symbol, float $value, string $datetime = null): bool
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
        } catch (\Throwable $th) {
            throw new \Exception("Could not insert rate: " . $th->getMessage());
        }
    }

    /**
     * Select all rates greater than a given id
     *
     * @param  int $id The result will get the rates greater than this id
     * @param  int $limit A limiter to the result to prevent memory problems
     *
     * @return array The selection result
     */
    public function selectRates(int $id = 0, int $limit = 200): array
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM rates WHERE id > :id ORDER BY id LIMIT :limit");

            $stmt->bindParam("id", $id);
            $stmt->bindParam("limit", intval($limit), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw new \Exception("Could not retrieve rates: " . $th->getMessage());
        }
    }

    /**
     * Deletes a rate record
     *
     * @param  int $id The rate id
     *
     * @return bool Returns whether the query execution was successful or not
     */
    public function deleteRate(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM rates WHERE id = :id");

            $stmt->bindParam("id", $id);

            return $stmt->execute();
        } catch (\Throwable $th) {
            throw new \Exception("Could not retrieve rates: " . $th->getMessage());
        }
    }
}
