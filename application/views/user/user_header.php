<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <style>
    html {
        background: #eee
    }
    </style>
</head>

<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://bulma.io">
                <!--<img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">-->
                <strong class="has-text-primary is-size-5">Cryptovest.ID</strong>
            </a>

            <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">
                    Dashboard
                </a>

                <a href="<?= base_url('user/investment'); ?>" class="navbar-item">
                    Investment
                </a>

            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a href="<?= base_url('user/mywallet'); ?>" class="button is-primary">
                            My Wallet
                        </a>
                        <a class="button is-danger is-outlined">
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>