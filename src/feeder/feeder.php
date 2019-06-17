<?php

require_once "../include/CurrencyDB.class.php";

try {
    $db = new CurrencyDB();
    $db->connect();

    // currency that will be matched/converted against others
    $baseCurrency = "BRL";

    // currencies to be matched/converted according to the base
    $symbols = [
        "USD",
        "EUR",
        "GBP"
    ];

    $ratesUrl = "https://api.exchangeratesapi.io/latest?base=" . $baseCurrency . "&symbols=" . implode(",", $symbols);
    
    while (true) {
        $jsonStr = file_get_contents($ratesUrl);
        $jsonArr = json_decode($jsonStr, true);

        $timezone = new DateTimeZone("America/Sao_Paulo");
        $datetime = new DateTime("now", $timezone);
        $dtStr = $datetime->format("Y-m-d H:i:s");
        
        foreach ($jsonArr["rates"] as $rate => $value) {
            $db->insertRate($jsonArr["base"], $rate, $value, $dtStr);
        }

        sleep(10);
    }
} catch (\Throwable $th) {
    echo "[ERROR] " . $th->getMessage() . " | File: " . $th->getFile() . " | Line: " . $th->getLine() . PHP_EOL;
}
