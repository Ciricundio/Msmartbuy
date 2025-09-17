<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Compra Exitosa</title>
  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f9fafb;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      color: #111827;
    }

    .check-icon {
      background: #2ECB70;
      color: white;
      border-radius: 50%;
      width: 100px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 60px;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    p {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 30px;
      max-width: 300px;
    }

    .btn {
      display: block;
      width: 220px;
      padding: 12px;
      margin: 8px auto;
      font-size: 15px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-gray {
      background: #f3f4f6;
      color: #2ECB70;
    }

    .btn-green {
      background: #2ECB70;
      color: white;
    }

    .btn-green:hover {
      background: #26a85d;
    }
  </style>
</head>
<body>
  <div class="check-icon">✔</div>
  <h1>La Compra Se Realizó Con Éxito</h1>
  <p>Ahora espera tu pedido en tu casita.  
     Si llegas a tener inconvenientes no dudes en reportarnos por el “Soporte”.</p>

  <a href="../compras/mis_compras.php" class="btn btn-gray">MIS COMPRAS</a>
  <a href="../home/home.php" class="btn btn-green">Inicio</a>
</body>
</html>
