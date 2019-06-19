<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="index.css">

    <title>Simple Currency Storage</title>
</head>

<body>

    <div id="main" class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1 class="display-1">How much is 1 BRL?</h1>
                </div>
            </div>
            <div id="rates" class="row mt-5 mb-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Last update</th>
                            <th class="text-center th-rate">USD</th>
                            <th class="text-center th-rate">EUR</th>
                            <th class="text-center th-rate">GBP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <h3 class="display-5">Next fetch in <span id="seconds">30</span> seconds</h3>
            </div>
        </div>
    </div>

    <script src="index.js"></script>
</body>

</html>