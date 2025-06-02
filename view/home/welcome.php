<?php require '../../controller/security/secure_login.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSmartBuy - Bienvenida</title>
    <link rel="stylesheet" href="../../public/css/welcome.css">
    <link rel="icon" href="../../public/img/Icono/Icon_msb.svg">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    
<body>

    <main class="container py-4 text-center">
        <div class="bienvenida">
            <h1 class="texto-bienvenido mt-2">
                <span class="up">Bienvenido A</span>
                <br>
                <span class="ms">MSmart<span class="buy">Buy</span></span>
            </h1>
        </div>
        <div class="ilustracion">
            <img src="../../public/img/ilustraciones/Bienvenida/cliente.svg" alt="Amigos juntos">
        </div>

        <div class="botones_inferiores">

            <button class="p-2 fw-bold my-3" id="btn" onclick="window.location.href='home.php'">INICIO</button>
            </br>
            <a class="text-muted fw-bold" id="link" href="#">Más sobre Msmartbuy</a>
            
        </div>
        

    </main>
</body>
</html>
