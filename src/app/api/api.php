<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../include/CurrencyDB.class.php";

try {
    header("Content-type:application/json");

    $db = new \CurrencyDB();
    $db->connect();

    $response = [];

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $id = $_GET["id"] ?? 0;
            $rates = $db->selectRates($id);

            $response = [
                "success" => true,
                "rates" => $rates
            ];
            break;

        case "DELETE":
            $id = $_GET["id"];

            $response = [
                "success" => $db->deleteRate($id)
            ];
            break;

        default:
            $response = [
                "success" => false,
                "message" => "Request unknown"
            ];
    }

    echo json_encode($response);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => "[ERROR] " . $th->getMessage() . " | File: " . $th->getFile() . " | Line: " . $th->getLine() . PHP_EOL
    ]);
}
