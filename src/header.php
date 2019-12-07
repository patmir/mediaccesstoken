<!doctype html>
<html lang="pl">

<head>
    <title><?= $title; ?></title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="src/styl.css" rel="stylesheet">
</head>

<body class="text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="alert alert-danger alert-dismissible show fade <?= !$showError ? "d-none" : ""; ?> role=" alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">Uwaga!</h4>
                    <p id="alert-message"><?= $errorMessage; ?></p>
                    <hr>
                    <p class="mb-0">Spróbuj ponownie.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="col-10 col-sm-12">
                <img class="mb-3" src="src/logo.png" alt="logo">
                <h1 class="display-4 font-weight-normal"><?= $nazwaWydarzenia; ?></h1>
            </div>
        </div>