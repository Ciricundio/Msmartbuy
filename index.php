<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSmartBuy - Hola</title>
    <link rel="icon" href="public/img/Icono/Icon_msb.svg">
<!-- CSS de la página -->
    <link rel="stylesheet" href="public/css/hello.css">
<!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    
<body>

    <div class="container text-center">
        <!-- Circulos decorativos -->
        <img class="circle-sm circle-md circle-lg circle-xl position-absolute top-0 end-0 z-n1" src="public/img/Ilustraciones/figuras/circle.svg" alt="circle">
        <img class="circle-sm-centro circle-md-centro circle-lg-centro circle-xl-centro position-absolute z-n1" src="public/img/Ilustraciones/figuras/circle.svg" alt="circle">
        <img class="circle-sm circle-md circle-lg circle-xl position-absolute bottom-0 start-0 z-n1" src="public/img/Ilustraciones/figuras/circle.svg" alt="circle">

        <h1 class="texto-hola mt-4">¡HOLA!</h1>
        
        <div class="ilustracion">
            <img src="public/img/Ilustraciones/hello.svg" class="rounded mx-auto d-block">
        </div>

        <div class="mt-5 pb-3">
            <p>Compra en linea de manera rápida y segura con MSmartBuy.</p>
            
            <div class="botones_inferiores">

                <button class="p-2 fw-bold mb-3" id="btn" onclick="window.location.href='view/auth/signup.php'">EMPEZAR</button>
                </br>
                <a class="text-black fw-bold" id="link" href="view/auth/login.php">YA TENGO CUENTA</a>
                
            </div>

        </div>
    </div>

</body>
</html>
