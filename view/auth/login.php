<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/img/Icono/Icon_msb.svg">
    <title>MSmartBuy - Inicio de sesión</title>
<!-- CSS de la página -->
    <link rel="stylesheet" href="../../public/css/login.css">
<!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Iconos de Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility_off" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=ver" />
    
</head>
<body>
        <div class="container">
            <div class="row">

                <div class="col-md-6 p-0">
                    <div class="all-space p-4">
                        <h1 class="mb-3 text-center ">
                            MSmart<span class="buy">Buy</span>
                        </h1> 

                        <p class="p-superior d-block d-md-none fs-6">¡Nos alegra verte otra vez! tu tienda personalizada te está esperando.</p>

                        <div>
                            <img src="../../public/img/Ilustraciones/happy.svg" alt="imagen de croods">
                        </div>

                        <p class="p-inferior d-none d-md-block text-end mt-4 fs-5">¡Nos alegra verte otra vez! tu tienda personalizada te está esperando.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="container-right">

                        <h2 class="d-md-block d-none mt-4 text-center">Iniciar sesión</h2>

                        <form action="../../model/Auth/login.php" method="POST">

                            <div class="p-4 border formulario bg-white">  

                                <div class="input">
                                    
                                    <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="email">Email</label>
                                        <input type="email" name="email" id="email" placeholder="Example@gmail.com" required>
                                    </div>

                                    <div class="mt-3 position-relative">
                                        <label class="text d-flex align-self-center ps-2" for="password">Contraseña</label>
                                        <input type="password" class="passwords" name="pasword" id="password" placeholder="*******" required>
                                        <span class="material-symbols-outlined" id="togglePassword" style="cursor: pointer; position: absolute; top: 50%; right: 10px;">
                                        visibility_off
                                        </span>
                                    </div>
                                </div> 

                                <div class="m-3 text-end">
                                    <a class="text-black" href="#" id="link">¿Olvidaste la contraseña?</a>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="p-2 fw-bold mb-2" id="btn" type="submit">INGRESAR A MI CUENTA</button>
                            </div>

                        </form>  

                        <div class="container-bottom">

                            <p>O Continuar Con:</p>
                            
                            <div class="logo-container">
                                <a href="#">
                                    <img src="../../assets/logos_api/google.svg" alt="Google Logo" class="logo">
                                </a>
                                <a href="#">
                                    <img src="../../assets/logos_api/facebook.svg" alt="Facebook Logo" class="logo">
                                </a>
                            </div>
                            
                            <a href="signup.php" class="signup-text">¿Aún no tienes una cuenta? Únete</a>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    <footer></footer>

    <script src="../../public/js/eye.js"></script>
</body>
</html>