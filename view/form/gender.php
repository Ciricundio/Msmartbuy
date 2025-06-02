<?php require '../../controller/security/secure_signup.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/img/Icono/Icon_msb.svg">
    <title>MSmartBuy - Registrandote</title>
<!-- CSS de la página -->
<link rel="stylesheet" href="../../public/css/elements/options.css">
<!--Boostrap-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container px-4 d-grid justify-content-center align-items-center">
<!-- textos superiores -->
        <div class="mx-4 mt-4">
            <h1 class="fs-4">Ya casi</h1>

            <div class="titulo">
                <p class="p-inferior me-5">Selecciona el genero con el que te identifiques.</p>
            </div>
        </div>
<!-- recuadro de opciones -->
        <form action="../../model/Auth/signup.php" method="post">

            <div class="row flex-column">
<!-- cuadro de la opción cliente -->
                <div class="col opcion1 cuadro" data-role="femenino" name="femenino">

                    <div class="c0 circulo1 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/femenino.svg" alt="user" id="img">
                    </div>
                    <h2 class="text-center">Femenino</h2>
                    
                </div>

<!-- cuadro de la opción proveedor -->
                <div class="col opcion2 cuadro" data-role="masculino" name="masculino">

                    <div class="c0 circulo2 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/masculino.svg" alt="send truck" id="img">
                    </div>

                    <h2 class="text-center">Masculino</h2>

                </div>

<!-- cuadro de la opción repartidor -->
                <div class="col opcion3 cuadro" data-role="otro" name="otro">

                    <div class="c0 circulo3 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/otro.svg" alt="delivery box" id="img">
                    </div>

                    <h2 class="text-center">Otro</h2>
                    
                </div>
            </div>

            <div class="my-4 d-flex justify-content-center">
                <button class="p-2 fw-bold mb-2" id="btn" type="submit">SIGUIENTE</button>
            </div>

        </form> 

    </div>
    
    <script type="module" src="../../public/js/section.js"></script> 
</body>

</html>

