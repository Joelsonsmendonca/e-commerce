<?php
    include 'MySql.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="/e-commerce" class="d-inline-flex link-body-emphasis text-decoration-none">
                <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="#" class="nav-link px-2">Features</a></li>
            <li><a href="#" class="nav-link px-2">Pricing</a></li>
            <li><a href="#" class="nav-link px-2">FAQs</a></li>
            <li><a href="#" class="nav-link px-2">About</a></li>
        </ul>
        <?php

            if(!isset($_SESSION['login'])){
        ?>
        <div class="col-md-3 text-end">
            <button type="button" id="Login" class="btn btn-outline-primary me-2">Login</button>
            <button type="button" id="Cadastro" class="btn btn-primary">Sign-up</button>
        </div>
        <?php }else{ ?>
                <button type="button" class="btn btn-primary">cadastrar produto</button>
                <button id="deslogar" type="button" class="btn btn-primary">deslogar</button>

            <?php } ?>
    </header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php

        if(isset($_SESSION['login'])){
            echo '<h3>Bem-vindo. ' .$_SESSION['login'];
        }

        if(isset($_GET['url'])){
            $url = $_GET['url'];
            if(file_exists('pages/'.$url.'.php')){
                include('pages/'.$url.'.php');
            }else{
                include('pages/404.php');
            }
        }
    ?>

    <script>
        document.getElementById('Login')?.addEventListener('click',()=>{
           window.location.href="?url=login";
        });
        document.getElementById('Cadastro')?.addEventListener('click',()=>{
            window.location.href="?url=cadastro";
        });
       document.getElementById('deslogar')?.addEventListener('click',()=>{
            window.location.href="?url=Login&acao=deslogar";
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>