<?php
session_start();

if (isset($_GET['idOferta'])) {
    $idOferta = $_GET['idOferta'];
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a La Cuponera SV</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        .footer {
            background-color: #212529;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .login-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 50px;
        }
        .login-option {
            flex: 1 1 30%;
            padding: 20px;
            margin: 10px;
            background-color: #495057;
            border-radius: 10px;
        }
        .login-option h2 {
            text-align: center;
        }
        .navbar .nav-link {
            color: #fff;
        }
        .navbar-text {
            color: #fff;
        }
        .credit-card-form {
            background-color: #495057;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .credit-card-form label {
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">La Cuponera SV</a>
        <?php if (isset($_SESSION['usuario'])): ?>
            <span class="navbar-text">
                Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (<?php echo htmlspecialchars($_SESSION['tipo_usuario']); ?>)
            </span>
            <?php if ($_SESSION['usuario'] === 'admin'): ?>
                <a class="nav-link" href="views/admin.php">Administrar</a>
            <?php endif; ?>
            <?php if ($_SESSION['tipo_usuario'] === 'empresa'): ?>
                <a class="nav-link" href="views/empresas/cupones.php">Registrar cup&oacute;n</a>
            <?php endif; ?>
            <a class="nav-link" href="../logout.php">Cerrar sesi&oacute;n</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container mt-4">
    <h1>Bienvenido a La Cuponera SV</h1>
    <p>&iexcl;Encuentra las mejores ofertas y descuentos aqu&iacute;!</p>

    <?php if (!isset($_SESSION['usuario'])): ?>
        <!-- Opciones de ingreso y registro -->
        <div class="login-container">
            <div class="login-option">
                <h2><a href="views/login.php">Ingreso</a></h2>
            </div>
            <div class="login-option">
                <h2><a href="views/empresas/registrar.php">Registro Empresas</a></h2>
            </div>
            <div class="login-option">
                <h2><a href="views/usuarios/registrar.php">Registro Usuarios</a></h2>
            </div>
        </div>
    <?php else: ?>
        <!-- Formulario de tarjeta de cr&eacute;dito -->
        <div class="credit-card-form">
            <h2>Pago con Tarjeta de Cr&eacute;dito</h2>
            <form id="paymentForm">
                <div class="form-group">
                    <label for="cardNumber">N&uacute;mero de Tarjeta</label>
                    <input type="text" class="form-control" id="cardNumber" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label for="expiryDate">Fecha de Vencimiento</label>
                    <input type="month" class="form-control" id="expiryDate" required>
                </div>
                <div class="form-group">
                    <label for="cvv">C&oacute;digo de Seguridad (CVV)</label>
                    <input type="text" class="form-control" id="cvv" maxlength="3" required>
                </div>
                <button type="submit" class="btn btn-primary">Pagar</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Regresar</button>
            </form>
            <div id="paymentResult" class="mt-3"></div>
        </div>
    <?php endif; ?>

</div>

<!-- Pie de página -->
<footer class="footer">
    <div class="container">
        <span>&copy; <?php echo date("Y"); ?> La Cuponera SV. Todos los derechos reservados.</span>
    </div>
</footer>

<!-- Archivos JavaScript de Bootstrap -->
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script>
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const expiryDate = new Date(document.getElementById('expiryDate').value);
        const currentDate = new Date();
        
        const resultDiv = document.getElementById('paymentResult');
        
        if (expiryDate > currentDate) {
    resultDiv.textContent = 'Pago exitoso. &iexcl;Gracias por su compra!';
    resultDiv.style.color = 'green';

    // Verificar el valor de idOferta
    //console.log('idOferta:', $idOferta);

    setTimeout(function() {
        // Verificar la URL antes de redirigir
        const url = 'procesarcompra.php?idOferta=<?php echo $idOferta;?>';
        console.log('Redirigiendo a:', url);
        
        window.location.href = url;
    }, 2000);

} else {
    resultDiv.textContent = 'La tarjeta está vencida. Por favor, use una tarjeta válida.';
    resultDiv.style.color = 'red';
}

    });
</script>
</body>
</html>
