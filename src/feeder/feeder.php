<?php

require_once "CurrencyDB.class.php";

try {
    $db = new CurrencyDB();
    $db->connect();

    while (true) {
        $db->insertRate("BRL", "USD", mt_rand(0, 10 * 10000000) / 1000000);
        $db->insertRate("BRL", "GBP", mt_rand(0, 10 * 10000000) / 1000000);
        $db->insertRate("BRL", "EUR", mt_rand(0, 10 * 10000000) / 1000000);

        sleep(10);
    }
} catch (\Throwable $th) {
    echo "[ERROR] " . $th->getMessage() . PHP_EOL;
}
