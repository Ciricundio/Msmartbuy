<?php require '../../controller/security/secure_signup.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../public/img/Icono/Icon_msb.svg">
        <title>MSmartBuy - Registrandote</title>
    <!-- CSS de la página -->
    <link rel="stylesheet" href="../../public/css/date.css">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    </head>
    <body>

        <div class="container px-4">
            <!-- textos superiores -->
            <div class="mx-4 mt-4">
                <h1 class="fs-4">¿Cuándo cumples años?</h1>

                <div class="titulo">
                    <p class="p-inferior">Ingresa tu fecha de nacimiento.</p>
                </div>
            </div>

            <div class="imagen d-flex justify-content-center"></div>

            <div class="">
            <!-- recuadro de opciones -->
                <form action="../../model/Auth/signup.php" method="POST" onsubmit="return enviarFecha()">
                    <div class="picker-wrapper">
                        <div class="highlight">
                        </div>
                        <div class="picker">
                            <div class="picker-column" id="col-dia"></div>
                            <div class="picker-column" id="col-mes"></div>
                            <div class="picker-column" id="col-anio"></div>
                        </div>
                    </div>
            
                    <input type="hidden" name="fecha_nacimiento" id="fecha_nacimiento">
                    <button type="submit" class="p-2 fw-bold mb-2" id="btn">SIGUIENTE</button>
                </form>
            </div>
        </div>
    </body>
    <script src="../../public/js/date.js"></script>
</html>