<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/img/Icono/Icon_msb.svg">
    <title>MSmartBuy - Registrate</title>
<!-- CSS de la página -->
    <link rel="stylesheet" href="../../public/css/signup.css">
<!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-md-6 p-0">
                <div class="all-space p-4">
                        <h1 class="text-start text-md-center mt-4 px-3 fs-2">Cuentanos un poco de tí</h1> 

                        <p class="p-superior d-block d-md-none px-3 text-start fs-6">Simplifica tu vida con MSmartBuy ¡Regístrate y disfruta!</p>

                    <div>
                        <img src="../../public/img/Ilustraciones/happy.svg" alt="imagen de croods" class="ilustracion_inicio">
                    </div>

                    <p class="p-inferior d-none d-md-block text-end mt-4 fs-5">Simplifica tu vida con MSmartBuy ¡Regístrate y disfruta!</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="container-right">
                    <h2 class="d-md-block d-none mt-4 text-center">Regístrate</h2>

                    <form action="../../model/auth/signup.php" method="POST">
                        <div class="p-4 border formulario bg-white">
                        
                            <div class="input">
                                
                                <div class="input_par">
                                    <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="name">Nombre</label>
                                        <input type="text" name="nombre" id="name" placeholder="Wolfgang" minlength="3" required>
                                    </div>

                                    <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="lastname">Apellidos</label>
                                        <input type="text" name="apellido" id="lastname" placeholder="Amadeus" minlength="4" required>
                                    </div>
                                </div>
                                
                                <div class="ingreso-dato">
                                    <label class="text d-flex aling-self-center ps-2" for="email">Email</label>
                                    <input type="email" name="correo" id="email" placeholder="example@gmail.com" required>
                                </div>

                                <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="text d-flex aling-self-center ps-2">Contraseña</label>
                                <input type="password" 
                                class="passwords" 
                                name="contrasena" 
                                id="password" 
                                placeholder="*******" 
                                minlength="8" 
                                pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$"
                                required>
                                </div>
                                
                                <div class="ingreso-dato">
                                    <label class="text d-flex aling-self-center ps-2" for="password_check">Confirma contraseña</label>
                                    <input type="password" 
                                    class="passwords" 
                                    name="password_check" 
                                    id="password_check" 
                                    placeholder="*******" 
                                    minlength="8" 
                                    pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$"
                                    required>
                                </div>

                                <div class="input_par">
                                    <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="number">Telefono</label>
                                        <input type="text" name="telefono" id="number" placeholder="3210000000" minlength="10" required>
                                    </div>

                                    <div class="ingreso-dato">
                                        <label class="text d-flex aling-self-center ps-2" for="zone">Zona</label>
                                        <select name="zone" id="zone" required>
                                            <option value="0" selected>Selecciona tu zona</option>
                                            <option value="La Jagua de Ibirico">La Jagua de Ibirico</option>
                                            <option value="La Palmita">La Palmita</option>
                                            <option value="La Victoria">La Victoria</option>
                                        </select>
                                    </div> 

                                </div>

                                <div class="mt-3 text-end">
                                    <a class="text-black d-none d-md-block" href="#" id="link">Otro método</a>
                                </div>

                            </div>

                        </div>

                        <div class="mt-4">
                            <button class="p-2 fw-bold mb-2" id="btn" type="submit" disabled>SIGUIENTE</button>
                        </div>
                    </form>

                    <div class="container-bottom d-block d-md-none">

                        <p>O Continuar Con:</p>
                        
                        <div class="logo-container">
                            <a href="#">
                                <img src="../../assets/logos_api/google.svg" alt="Google Logo" class="logo">
                            </a>
                            <a href="#">
                                <img src="../../assets/logos_api/facebook.svg" alt="Facebook Logo" class="logo">
                            </a>
                        </div>
                        
                        <a href="login.php" class="signup-text">Ya tengo cuenta</a>
    
                    </div>

                </div>
                
            </div>
        </div>

    </div>
</body>

<script src="../../controller/auth/password_verification.js"></script>

</html>