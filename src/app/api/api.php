<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../include/CurrencyDB.class.php";

try {
    $db = new CurrencyDB();
    $db->connect();

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $id = $_GET["id"] ?? 0;
            $rates = $db->selectRates($id);

            echo json_encode([
                "success" => true,
                "rates" => $rates
            ]);
            break;

        case "DELETE":
            $id = $_GET["id"];

            echo json_encode([
                "success" => $db->deleteRate($id)
            ]);
            break;
    }
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => "[ERROR] " . $th->getMessage() . " | File: " . $th->getFile() . " | Line: " . $th->getLine() . PHP_EOL
    ]);
}
