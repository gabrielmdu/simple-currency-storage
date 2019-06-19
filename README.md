# simple-currency-storage

A very simple web app for currency storage, verification and deletion. The app shows a table with exchange rate values for 3 currencies based on the Brazilian Real. Every 30 seconds new values are queried from the database through an API. It is possible to hide or delete any row of values from the table.

## Files

- *app/index.** - Front-end files
- *app/api/api.php* - The API that returns AJAX requests from the database
- *feeder/feeder.php* - A script to fetch rate values from an external API and populate the database. It runs every 60 seconds.
- *include/CurrencyDB.class.php* - A class to handle the currency database
- *db.sql* - The rates table that is created after the database's Docker container

## How to start

To start the services, run

    docker-compose up -d

Then run the feeder script to begin database population

    docker-compose exec -d webserver php /home/simple-currency-storage/feeder/feeder.php

Open localhost:8080