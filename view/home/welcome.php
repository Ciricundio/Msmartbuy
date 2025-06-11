<?php
require '../../controller/security/secure_login.php';

$rol = $_SESSION['rol'] ?? 'Invitado'; 
?>

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
                <span class="ms">MSmart
                    <span class="buy" 
                    <?php 
                    switch ($rol){
                        case "cliente":
                            echo "style='color: var(--verde);'";
                        break;

                        case "admin":
                            echo "style='color: var(--lila);'";
                        break;

                        default:
                        echo "¡Ojo con lo que haces!";

                    }
                ?>
                >Buy
                    </span>
                </span>
            </h1>
        </div>
        <div class="ilustracion">
            <?php 
                switch ($rol){
                    case "cliente":
                        echo '<img src="../../public/img/Ilustraciones/Bienvenida/cliente.svg">';
                    break;

                    case "admin":
                        echo '<img src="../../public/img/Ilustraciones/Bienvenida/admin.svg">';
                    break;

                    default:
                    echo "¡Ojo con lo que haces!";

                }
                 
                ?>
        </div>

        <div class="botones_inferiores">

            <button class="p-2 fw-bold my-3" id="btn" 
            <?php 
                switch ($rol){
                    case "cliente":
                        echo "onclick=\"window.location.href='home.php'\"";
                        echo "style='background-color: var(--verde);'";
                    break;

                    case "admin":
                        echo "onclick=\"window.location.href='../../role/admin/view/home/ad_home.php'\"";
                        echo "style='background-color: var(--lila);'";
                    break;

                    default:
                    echo "¡Ojo con lo que haces!";

                }
            ?>
            >INICIO</button>
            </br>
            <a class="text-muted fw-bold" id="link" href="#">Más sobre Msmartbuy</a>
            
        </div>
        

    </main>
</body>
</html>
