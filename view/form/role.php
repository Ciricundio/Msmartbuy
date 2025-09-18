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
            <h1 class="fs-4">¿Quieres usar MSmartBuy como?</h1>

            <div class="titulo">
                <p class="p-inferior">Selecciona la opción que más convenga para usar tu tienda Online.</p>
            </div>
        </div>
<!-- recuadro de opciones -->
        <form action="../../model/auth/signup.php" method="POST">

            <div class="row flex-column">
<!-- cuadro de la opción cliente -->
                <div class="col opcion1 cuadro" data-role="cliente" name="cliente">

                    <div class="c0 circulo1 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/cliente.svg" alt="user" id="img">
                    </div>
                    <h2 class="text-center">Cliente</h2>
                    
                </div>

<!-- cuadro de la opción proveedor -->
                <div class="col opcion2 cuadro" data-role="proveedor" name="proveedor">

                    <div class="c0 circulo2 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/proveedor.svg" alt="send truck" id="img">
                    </div>

                    <h2 class="text-center">Proveedor</h2>

                </div>

<!-- cuadro de la opción repartidor -->
                <div class="col opcion3 cuadro" data-role="repartidor" name="repartidor">

                    <div class="c0 circulo3 d-flex justify-content-center align-items-center">
                        <img src="../../public/img/Ilustraciones/figuras/repartidor.svg" alt="delivery box" id="img">
                    </div>

                    <h2 class="text-center">Repartidor</h2>
                    
                </div>
            </div>

            <div class="my-4 d-flex justify-content-center">
                <button class="p-2 fw-bold mb-2" id="btn" type="submit">SIGUIENTE</button>
            </div>

        </form> 

    </div>

    <div id="modalAdvertencia" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1000; justify-content:center; align-items:center;">
        <div style="background:white; padding:20px 30px; border-radius:10px; text-align:center; max-width:300px;">
            <p style="margin-bottom: 20px;">Esta opción aún no está habilitada.</p>
            <button  class="p-2 fw-bold mb-2 w-75" onclick="document.getElementById('modalAdvertencia').style.display='none'" id="btn">Cerrar</button>
        </div>
    </div>
    
    <script type="module" src="../../public/js/section.js"></script> 
</body>

</html>

