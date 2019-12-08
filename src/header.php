<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $nazwaWydarzenia; ?>">
    <meta name="author" content="Patryk Mirosław 2019; miroslaw.patryk@gmail.com">
    <title><?= $title; ?></title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="src/styl.css" rel="stylesheet">
    <link href="custom/mojstyl.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-light bg-light sticky-top">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-<?= isset($file) ? "between" : "around"; ?>"">
            <a class=" py-2 d-sm-block d-md-inline-block <?= isset($file) ? "" : "navbar-brand"; ?>" href="#">
            <img src="custom/logo.png" class="nav-logo img-fluid d-inline-block align-top" alt="logo" />
            </a>
            <span class="navbar-text py-2 d-sm-block d-md-inline-block font-weight-bold h2 text-break text-center"><?= $nazwaWydarzenia; ?></span>
            <?php if (isset($file)) : ?>
                <a class="btn btn-lg py-2 d-sm-block d-md-inline-block btn-outline-success" type="button" id="button-pobierz" href="<?= $file ?>" download><?= $przyciskPobierz; ?></a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container py-2">
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